<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="description" content="{{ $globalSettings['seo_meta_description'] ?? 'Student Dashboard — University OBE File Management System' }}">
    <title>@yield('page-title', 'Student') — {{ $globalSettings['student_tab_title'] ?? 'Student Dashboard - OBE System' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
    @stack('styles')
</head>
<body>

<div class="sb-overlay" id="overlay"></div>

<!-- SIDEBAR -->
@include('layouts.partials.student-sidebar')

<!-- MAIN -->
<div class="main">
    
    <!-- TOPBAR -->
    @include('layouts.partials.student-topbar')

    <!-- PAGE CONTENT -->
    <main class="page-content">
        @yield('content')
    </main>

    <!-- FOOTER -->
    @include('layouts.partials.footer')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Sidebar toggle logic
        const desktopToggleBtn = document.getElementById('toggleBtn');
        const mobileToggleBtn = document.getElementById('mobileToggleBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        
        if(sidebar) {
            // Restore state for desktop
            if(localStorage.getItem('sidebar-collapsed-student') === 'true' && window.innerWidth > 992) {
                sidebar.classList.add('collapsed');
            }

            if(desktopToggleBtn) {
                desktopToggleBtn.onclick = () => {
                    if (window.innerWidth <= 992) {
                        sidebar.classList.remove('show');
                        if(overlay) overlay.classList.remove('show');
                    } else {
                        sidebar.classList.toggle('collapsed');
                        localStorage.setItem('sidebar-collapsed-student', sidebar.classList.contains('collapsed'));
                    }
                };
            }

            if(mobileToggleBtn) {
                mobileToggleBtn.onclick = () => {
                    sidebar.classList.toggle('show');
                    if(overlay) overlay.classList.toggle('show');
                };
            }
            
            if(overlay) {
                overlay.onclick = () => { 
                    sidebar.classList.remove('show'); 
                    overlay.classList.remove('show'); 
                };
            }
        }
    });
</script>
@include('partials.sweetalert')
@stack('scripts')
@stack('modals')

</body>
</html>
