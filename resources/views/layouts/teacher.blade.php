<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Teacher Dashboard - OBE System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; overflow-x: hidden; }
        
        /* Sidebar layout adjustment */
        .sidebar { 
            height: 100vh; 
            background: #1a1a1a; 
            color: white; 
            position: fixed; 
            width: 250px; 
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: 1050;
            transition: all 0.3s ease;
        }
        
        /* Centralized User Profile Styling */
        .user-profile {
            text-align: center;
            padding: 0 15px;
            margin-bottom: 30px;
        }
        .user-profile h5 { 
            margin: 0; 
            font-weight: bold; 
            color: #fff; 
            font-size: 1.1rem;
        }
        .user-profile p { 
            margin: 5px 0 0 0; 
            color: #adb5bd; 
            font-size: 0.85rem; 
        }

        .nav-link { color: #adb5bd; padding: 15px 25px; transition: 0.3s; }
        .nav-link:hover { background: #333; color: white; }
        .nav-link.active { background: #0d6efd; color: white; }
        
        .logout-section { border-top: 1px solid #333; padding: 10px 0; }
        
        .main-content { margin-left: 250px; padding: 30px; transition: all 0.3s ease; min-height: 100vh;}
        .card { border: none; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .stat-card { border-left: 5px solid #198754; } 
        .table thead { background-color: #198754; color: white; }

        /* Mobile Toggle Button */
        .sidebar-toggler {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
            background: #1a1a1a;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
        }

        @media (max-width: 992px) {
            .sidebar { left: -250px; }
            .sidebar.show { left: 0; }
            .main-content { margin-left: 0; padding-top: 70px; padding-left: 15px; padding-right: 15px; }
            .sidebar-toggler { display: block; }
            
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.5); z-index: 1040;
            }
            .sidebar-overlay.show { display: block; }
        }

        /* Extra small devices fix */
        @media (max-width: 360px) {
            .main-content { padding-left: 10px; padding-right: 10px; }
            .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <button class="sidebar-toggler" id="toggleBtn">
        <i class="fas fa-bars"></i> Menu
    </button>

    <div class="sidebar-overlay" id="overlay"></div>

    <div class="sidebar" id="sidebar">
        <div>
            <div class="user-profile">
                <h5>Masud Tarek</h5>
                <p>Associate Professor (CSE)</p>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route('teacher.dashboard') ?? '#' }}" class="nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}"><i class="fas fa-chalkboard-teacher me-2"></i> Teacher Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('teacher.courses.index') }}" class="nav-link {{ request()->routeIs('teacher.courses.*') ? 'active' : '' }}"><i class="fas fa-book me-2"></i> My Course Info</a></li>
                <li class="nav-item"><a href="{{ route('teacher.course-materials.index') }}" class="nav-link {{ request()->routeIs('teacher.course-materials.*') ? 'active' : '' }}"><i class="fas fa-upload me-2"></i> Upload Materials</a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-list me-2"></i> Category List (View Only)</a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-layer-group me-2"></i> Subcategory List (View Only)</a></li>
            </ul>
        </div>

        <div class="logout-section">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link text-danger w-100 text-start border-0 bg-transparent">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    <script>
        const toggleBtn = document.getElementById('toggleBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        toggleBtn.onclick = () => {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        overlay.onclick = () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @include('partials.sweetalert')
    @stack('scripts')
</body>
</html>
