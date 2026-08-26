<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo e($globalSettings['seo_meta_description'] ?? 'Admin Dashboard — University OBE File Management System'); ?>">
    <title><?php echo $__env->yieldContent('page-title', 'Admin'); ?> — <?php echo e($globalSettings['admin_tab_title'] ?? 'Admin Dashboard - OBE System'); ?></title>
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
            <div class="brand-logo" style="<?php echo e(isset($globalSettings['admin_logo']) && $globalSettings['admin_logo'] ? 'background: transparent; box-shadow: none;' : ''); ?>">
                <?php if(isset($globalSettings['admin_logo']) && $globalSettings['admin_logo']): ?>
                    <img src="<?php echo e(asset('storage/' . $globalSettings['admin_logo'])); ?>" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                <?php else: ?>
                    <i class="fas fa-graduation-cap"></i>
                <?php endif; ?>
            </div>
            <div class="brand-text">
                <span class="brand-name"><?php echo e($globalSettings['admin_dashboard_name'] ?? 'UniAdmin'); ?></span>
                <span class="brand-tagline"><?php echo e($globalSettings['brand_tagline'] ?? 'File Management'); ?></span>
            </div>
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
                    <a href="<?php echo e(route('admin.system-settings')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.system-settings') ? 'active' : ''); ?>">
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
                
                <!-- Global Search -->
                <div class="header-search dropdown" id="globalSearchContainer">
                    <form onsubmit="event.preventDefault(); window.performGlobalSearch();" class="d-flex align-items-center m-0">
                        <div class="search-input-wrapper position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="globalSearchInput" placeholder="Search..." autocomplete="off" style="padding-right: 30px; width: 100%;">
                            <button type="button" id="globalSearchClearBtn" title="Clear" style="display:none; position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background:none; border:none; color:var(--text-muted); padding: 0; z-index: 10;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <button type="button" onclick="window.performGlobalSearch()" id="globalSearchSubmitBtn" class="btn btn-primary btn-sm ms-2" style="display:none; padding: 6px 14px; border-radius: 6px;">
                            Search
                        </button>
                    </form>
                    <div class="dropdown-menu dropdown-menu-end premium-dropdown search-dropdown" id="globalSearchDropdown" style="max-height: 400px; overflow-y: auto; min-width: 320px;">
                        <div class="p-3 text-center text-muted" id="globalSearchInitialState">
                            <i class="fas fa-search fa-2x mb-2" style="opacity: 0.2;"></i>
                            <p class="mb-0" style="font-size: 0.85rem;">Type at least 2 characters to search...</p>
                        </div>
                        <div id="globalSearchResults"></div>
                    </div>
                </div>

                <!-- Notifications Dropdown -->
                <div class="dropdown" id="globalNotificationContainer">
                    <button class="header-icon-btn dropdown-toggle-hide-arrow" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications" id="notificationDropdownBtn">
                        <i class="fas fa-bell"></i>
                        <span class="notif-badge d-none" id="notificationBadgeCount"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end premium-dropdown notif-dropdown">
                        <div class="dropdown-header d-flex justify-content-between align-items-center">
                            <span>Notifications</span>
                            <span class="badge bg-primary rounded-pill d-none" id="notificationHeaderCount"></span>
                        </div>
                        <div class="dropdown-body" id="notificationBody">
                            <div class="text-center py-4 text-muted">
                                <div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div>
                                <p class="mb-0" style="font-size: 0.85rem;">Loading...</p>
                            </div>
                        </div>
                        <div class="dropdown-footer text-center">
                            <a href="javascript:void(0)" onclick="markNotificationsAsRead()" class="text-primary text-decoration-none" style="font-size: 0.8rem; font-weight: 500;">Mark all as read</a>
                        </div>
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
                        <a class="dropdown-item" href="<?php echo e(route('admin.profile')); ?>"><i class="fas fa-user-circle me-2"></i> My Profile</a>
                        <a class="dropdown-item" href="<?php echo e(route('admin.account-settings')); ?>"><i class="fas fa-cog me-2"></i> Account Settings</a>
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
        <div class="dashboard-footer" style="margin-top: auto; justify-content: center; text-align: center; width: 100%;">
            <span style="font-weight: 600; color: #64748b;"><?php echo e($globalSettings['footer_copyright'] ?? '© 2026 University File Management System'); ?></span>
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
    <script>
        // Global Search Logic
        const searchInput = document.getElementById('globalSearchInput');
        const clearBtn = document.getElementById('globalSearchClearBtn');
        const submitBtn = document.getElementById('globalSearchSubmitBtn');
        const resultsContainer = document.getElementById('globalSearchResults');
        const initialState = document.getElementById('globalSearchInitialState');
        let searchTimeout = null;

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const val = this.value.trim();
                if (val.length > 0) {
                    clearBtn.style.display = 'block';
                    submitBtn.style.display = 'block';
                    
                    if (val.length < 2) {
                        initialState.style.display = 'block';
                        initialState.innerHTML = '<p class="mb-0 text-muted" style="font-size: 0.85rem;">Keep typing...</p>';
                        resultsContainer.innerHTML = '';
                    } else {
                        initialState.style.display = 'block';
                        initialState.innerHTML = '<p class="mb-0 text-muted" style="font-size: 0.85rem;">Press Search or Enter to find results.</p>';
                        resultsContainer.innerHTML = '';
                    }
                } else {
                    clearBtn.style.display = 'none';
                    submitBtn.style.display = 'none';
                    resetSearch();
                }
            });

            clearBtn.addEventListener('click', function() {
                searchInput.value = '';
                clearBtn.style.display = 'none';
                submitBtn.style.display = 'none';
                resetSearch();
                searchInput.focus();
            });
        }

        function resetSearch() {
            resultsContainer.innerHTML = '';
            initialState.style.display = 'block';
            initialState.innerHTML = '<i class="fas fa-search fa-2x mb-2" style="opacity: 0.2;"></i><p class="mb-0" style="font-size: 0.85rem;">Type at least 2 characters to search...</p>';
        }

        window.performGlobalSearch = function() {
            const val = searchInput.value.trim();
            if (val.length < 2) return;
            
            initialState.style.display = 'block';
            initialState.innerHTML = '<div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div><p class="mb-0" style="font-size: 0.85rem;">Searching...</p>';
            resultsContainer.innerHTML = '';
            
            // Ensure dropdown is open safely
            try {
                const dropdownMenu = document.getElementById('globalSearchDropdown');
                if (dropdownMenu) {
                    dropdownMenu.classList.add('show');
                }
            } catch (e) {
                console.error(e);
            }

            fetch("<?php echo e(route('admin.global-search')); ?>?q=" + encodeURIComponent(val))
                .then(response => response.json())
                .then(data => {
                    initialState.style.display = 'none';
                    resultsContainer.innerHTML = '';

                    if (Object.keys(data).length === 0) {
                        resultsContainer.innerHTML = `
                            <div class="p-4 text-center">
                                <i class="fas fa-box-open fa-3x text-muted mb-3" style="opacity: 0.2;"></i>
                                <h6 class="text-heading fw-bold">No Results Found</h6>
                                <p class="text-muted small mb-0">We couldn't find anything matching "${val}".<br>Try checking for typos or using different keywords.</p>
                            </div>
                        `;
                        return;
                    }

                    let html = '';
                    for (const [group, items] of Object.entries(data)) {
                        html += `<div class="dropdown-header" style="font-weight:700; color:var(--text-heading); background:var(--bg-muted); padding:6px 16px;">${group}</div>`;
                        items.forEach(item => {
                            html += `
                                <a class="dropdown-item d-flex align-items-center py-2" href="${item.url}">
                                    <div class="icon-wrap me-3 d-flex justify-content-center align-items-center" style="width:32px; height:32px; border-radius:8px; background:var(--bg-light); border:1px solid var(--border-light);">
                                        <i class="fas ${item.icon} ${item.color}"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold" style="font-size:0.85rem; color:var(--text-body);">${item.title}</div>
                                        <div class="text-muted" style="font-size:0.75rem;">${item.subtitle}</div>
                                    </div>
                                </a>
                            `;
                        });
                    }
                    resultsContainer.innerHTML = html;
                })
                .catch(error => {
                    initialState.style.display = 'none';
                    resultsContainer.innerHTML = `
                        <div class="p-3 text-center text-danger">
                            <i class="fas fa-exclamation-circle mb-2"></i>
                            <p class="mb-0" style="font-size: 0.85rem;">An error occurred while searching.</p>
                        </div>
                    `;
                });
        };

        // --- Notification System JS ---
        document.addEventListener("DOMContentLoaded", function() {
            fetchNotifications();
            // Fetch periodically every 60 seconds
            setInterval(fetchNotifications, 60000);
        });

        function fetchNotifications() {
            fetch("<?php echo e(route('admin.notifications.fetch')); ?>")
                .then(response => response.json())
                .then(data => {
                    if(data.error) return;
                    
                    const badgeCount = document.getElementById('notificationBadgeCount');
                    const headerCount = document.getElementById('notificationHeaderCount');
                    const body = document.getElementById('notificationBody');
                    
                    if(data.count > 0) {
                        // Keep badge empty (just a red dot)
                        badgeCount.textContent = '';
                        badgeCount.classList.remove('d-none');
                        headerCount.textContent = data.count + ' New';
                        headerCount.classList.remove('d-none');
                    } else {
                        badgeCount.classList.add('d-none');
                        headerCount.classList.add('d-none');
                    }
                    
                    if(data.notifications.length === 0) {
                        body.innerHTML = '<div class="text-center py-4 text-muted" style="font-size:0.85rem;">No notifications found</div>';
                        return;
                    }
                    
                    let html = '';
                    data.notifications.forEach(notif => {
                        const icon = notif.data.icon || 'fa-info-circle';
                        const color = notif.data.color || 'primary';
                        // Format time
                        const date = new Date(notif.created_at);
                        const timeString = date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                        
                        // Check if unread
                        const unreadClass = notif.read_at === null ? 'unread' : '';
                        
                        const url = notif.data.url || 'javascript:void(0)';
                        
                        html += `
                            <a class="dropdown-item notif-item ${unreadClass}" href="javascript:void(0)" onclick="markSingleAsReadAndRedirect('${notif.id}', '${url}')">
                                <div class="notif-icon bg-light-${color} text-${color}"><i class="fas ${icon}"></i></div>
                                <div class="notif-content">
                                    <div class="notif-title">${notif.data.title}</div>
                                    <div class="notif-desc">${notif.data.description}</div>
                                    <div class="notif-time">${timeString}</div>
                                </div>
                            </a>
                        `;
                    });
                    body.innerHTML = html;
                })
                .catch(err => console.error(err));
        }

        window.markSingleAsReadAndRedirect = function(id, url) {
            fetch(`/admin/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(url && url !== 'javascript:void(0)') {
                    window.location.href = url;
                }
            })
            .catch(err => {
                if(url && url !== 'javascript:void(0)') window.location.href = url;
            });
        };

        window.markNotificationsAsRead = function() {
            fetch("<?php echo e(route('admin.notifications.read')); ?>", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    fetchNotifications();
                }
            });
        };
    </script>
</body>
</html>
<?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/layouts/admin.blade.php ENDPATH**/ ?>