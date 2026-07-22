<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Dashboard — University OBE File Management System">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard - OBE System'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

    <button class="sidebar-toggler" id="toggleBtn"><i class="fas fa-bars"></i></button>
    <div class="sidebar-overlay" id="overlay"></div>

    <!-- ====== SIDEBAR ====== -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-logo"><i class="fas fa-graduation-cap"></i></div>
            <div class="brand-text">
                <span class="brand-name">UniAdmin</span>
                <span class="brand-tagline">File Management</span>
            </div>
        </div>

        <div class="sidebar-profile">
            <div class="profile-avatar">HR</div>
            <div class="profile-info">
                <div class="profile-name">Hasanur Rahman</div>
                <div class="profile-role">Super Admin</div>
            </div>
            <div class="profile-status"></div>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-group-label">Overview</span>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                        <i class="fas fa-th-large"></i> Dashboard
                    </a>
                </li>
            </ul>

            <span class="nav-group-label">User Management</span>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.student-info.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.students.*', 'admin.student-info.*') ? 'active' : ''); ?>">
                        <i class="fas fa-user-graduate"></i> Students 
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.teacher-info.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.teachers.*', 'admin.teacher-info.*') ? 'active' : ''); ?>">
                        <i class="fas fa-chalkboard-teacher"></i> Teachers
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.admins.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.admins.*') ? 'active' : ''); ?>">
                        <i class="fas fa-user-shield"></i> Admins
                    </a>
                </li>
            </ul>

            <span class="nav-group-label">Academics</span>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.semesters.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.semesters.*') ? 'active' : ''); ?>">
                        <i class="fas fa-calendar-alt"></i> Semesters
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.courses.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.courses.*') ? 'active' : ''); ?>">
                        <i class="fas fa-book-open"></i> Courses
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.course-files.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.course-files.*') ? 'active' : ''); ?>">
                        <i class="fas fa-file-alt"></i> Course Files
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(Route::has('admin.departments.index') ? route('admin.departments.index') : '#'); ?>" class="nav-link <?php echo e(request()->routeIs('admin.departments.*') ? 'active' : ''); ?>">
                        <i class="fas fa-building-columns"></i> Departments
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.categories.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
                        <i class="fas fa-tags"></i> Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.subcategories.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.subcategories.*') ? 'active' : ''); ?>">
                        <i class="fas fa-layer-group"></i> Subcategories
                    </a>
                </li>
            </ul>
            
            <span class="nav-group-label">System</span>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo e(Route::has('admin.settings.index') ? route('admin.settings.index') : '#'); ?>" class="nav-link <?php echo e(request()->routeIs('admin.settings.*') ? 'active' : ''); ?>">
                        <i class="fas fa-gear"></i> Settings
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline w-100">
                <?php echo csrf_field(); ?>
                <button type="submit" class="logout-btn w-100 border-0 bg-transparent text-start">
                    <i class="fas fa-arrow-right-from-bracket"></i> Log Out
                </button>
            </form>
        </div>
    </div>

    <!-- ====== MAIN CONTENT ====== -->
    <div class="main-content">
        <!-- Top Header -->
        <div class="top-header">
            <div class="header-left">
                <div>
                    <h1 class="page-title"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h1>
                    <div class="breadcrumb-trail">
                        <a href="<?php echo e(route('admin.dashboard')); ?>">Home</a>
                        <span>/</span>
                        <span><?php echo $__env->yieldContent('breadcrumb', 'Dashboard'); ?></span>
                    </div>
                </div>
            </div>
            <div class="header-right">
                
                <!-- Search Dropdown (Simulated Global Search) -->
                <div class="header-search dropdown">
                    <div class="search-input-wrapper" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" placeholder="Search..." autocomplete="off">
                    </div>
                    <div class="dropdown-menu dropdown-menu-end premium-dropdown search-dropdown">
                        <div class="dropdown-header">Recent Searches</div>
                        <a class="dropdown-item" href="#"><i class="fas fa-history text-muted me-2"></i> File Upload Guidelines</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-history text-muted me-2"></i> Student Registry 2026</a>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-header">Suggestions</div>
                        <a class="dropdown-item" href="<?php echo e(route('admin.courses.index')); ?>"><i class="fas fa-book-open text-primary me-2"></i> Manage Courses</a>
                        <a class="dropdown-item" href="<?php echo e(route('admin.student-info.index')); ?>"><i class="fas fa-user-graduate text-success me-2"></i> Manage Students</a>
                    </div>
                </div>

                <!-- Notifications Dropdown -->
                <div class="dropdown">
                    <button class="header-icon-btn dropdown-toggle-hide-arrow" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notif-badge"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end premium-dropdown notif-dropdown">
                        <div class="dropdown-header d-flex justify-content-between align-items-center">
                            <span>Notifications</span>
                            <span class="badge bg-primary rounded-pill">2 New</span>
                        </div>
                        <div class="dropdown-body">
                            <a class="dropdown-item notif-item unread" href="#">
                                <div class="notif-icon bg-light-primary text-primary"><i class="fas fa-file-alt"></i></div>
                                <div class="notif-content">
                                    <div class="notif-title">New Course Material</div>
                                    <div class="notif-desc">Software Engineering syllabus uploaded</div>
                                    <div class="notif-time">2 mins ago</div>
                                </div>
                            </a>
                            <a class="dropdown-item notif-item unread" href="#">
                                <div class="notif-icon bg-light-success text-success"><i class="fas fa-user-check"></i></div>
                                <div class="notif-content">
                                    <div class="notif-title">New Registration</div>
                                    <div class="notif-desc">Jaden Austi registered as Student</div>
                                    <div class="notif-time">1 hour ago</div>
                                </div>
                            </a>
                            <a class="dropdown-item notif-item" href="#">
                                <div class="notif-icon bg-light-warning text-warning"><i class="fas fa-exclamation-triangle"></i></div>
                                <div class="notif-content">
                                    <div class="notif-title">System Alert</div>
                                    <div class="notif-desc">Server maintenance scheduled</div>
                                    <div class="notif-time">Yesterday</div>
                                </div>
                            </a>
                        </div>
                        <div class="dropdown-footer text-center">
                            <a href="#" class="text-primary text-decoration-none" style="font-size: 0.8rem; font-weight: 500;">View All Activity</a>
                        </div>
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="dropdown">
                    <button class="header-icon-btn dropdown-toggle-hide-arrow" data-bs-toggle="dropdown" aria-expanded="false" title="Settings">
                        <i class="fas fa-gear"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end premium-dropdown">
                        <div class="dropdown-header">Quick Settings</div>
                        <a class="dropdown-item" href="#"><i class="fas fa-sliders-h me-2"></i> System Preferences</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-shield-alt me-2"></i> Security Settings</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-database me-2"></i> Backup Data</a>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <div class="header-profile" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                        <?php
                            $user = Auth::user();
                            $name = $user ? $user->name : 'Admin User';
                            $initials = strtoupper(substr($name, 0, 2));
                            $role = $user ? ucfirst($user->role) : 'Administrator';
                        ?>
                        <div class="avatar"><?php echo e($initials); ?></div>
                        <div class="profile-text">
                            <div class="name"><?php echo e(Str::limit($name, 15)); ?></div>
                            <div class="role"><?php echo e($role); ?></div>
                        </div>
                    </div>
                    <div class="dropdown-menu dropdown-menu-end premium-dropdown profile-dropdown">
                        <div class="profile-header text-center p-3">
                            <div class="avatar-lg mx-auto mb-2"><?php echo e($initials); ?></div>
                            <h6 class="mb-0 fw-bold"><?php echo e($name); ?></h6>
                            <span class="text-muted small"><?php echo e($user ? $user->email : ''); ?></span>
                        </div>
                        <div class="dropdown-divider m-0"></div>
                        <a class="dropdown-item" href="#"><i class="fas fa-user-circle me-2"></i> My Profile</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Account Settings</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="m-0 p-0">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <!-- Footer -->
        <div class="dashboard-footer" style="margin-top: auto;">
            <span>© 2026 University File Management System</span>
            <span>UniAdmin Panel v2.0</span>
        </div>
    </div>

    <?php echo $__env->yieldPushContent('modals'); ?>

    <script>
        // Sidebar toggle logic
        const toggleBtn = document.getElementById('toggleBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        
        if(toggleBtn && sidebar && overlay) {
            toggleBtn.onclick = () => { 
                sidebar.classList.toggle('show'); 
                overlay.classList.toggle('show'); 
            }
            overlay.onclick = () => { 
                sidebar.classList.remove('show'); 
                overlay.classList.remove('show'); 
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Include SweetAlert partial if exists -->
    <?php if(view()->exists('partials.sweetalert')): ?>
        <?php echo $__env->make('partials.sweetalert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/layouts/admin.blade.php ENDPATH**/ ?>