<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="description" content="<?php echo e($globalSettings['seo_meta_description'] ?? 'Teacher Dashboard — University OBE File Management System'); ?>">
    <title><?php echo $__env->yieldContent('page-title', 'Teacher'); ?> — <?php echo e($globalSettings['teacher_tab_title'] ?? 'Teacher Dashboard - OBE System'); ?></title>
    <?php if(isset($globalSettings['teacher_favicon']) && $globalSettings['teacher_favicon']): ?>
        <link rel="icon" type="image/x-icon" href="<?php echo e(asset('storage/' . $globalSettings['teacher_favicon'])); ?>">
    <?php endif; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/teacher.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

<div class="sb-overlay" id="overlay"></div>

<!-- SIDEBAR -->
<?php echo $__env->make('layouts.partials.teacher-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- MAIN -->
<div class="main">
    
    <!-- TOPBAR -->
    <?php echo $__env->make('layouts.partials.teacher-topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- PAGE CONTENT -->
    <main class="page-content">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- FOOTER -->
    <?php echo $__env->make('layouts.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</div>

<!-- BACK TO TOP BUTTON -->
<div class="scroll-top-btn" id="scrollTopBtn">
    <svg class="progress-ring" width="48" height="48">
        <circle class="progress-ring__bg" stroke="var(--primary-light)" stroke-width="3" fill="transparent" r="22" cx="24" cy="24"/>
        <circle class="progress-ring__circle" stroke="var(--primary)" stroke-width="3" fill="transparent" r="22" cx="24" cy="24"/>
    </svg>
    <div class="scroll-top-icon">
        <i class="fas fa-arrow-up"></i>
    </div>
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
            if(localStorage.getItem('sidebar-collapsed-teacher') === 'true' && window.innerWidth > 992) {
                sidebar.classList.add('collapsed');
            }

            const syncBodyLock = () => {
                document.body.classList.toggle('sb-open', sidebar.classList.contains('show'));
            };

            if(desktopToggleBtn) {
                desktopToggleBtn.onclick = () => {
                    if (window.innerWidth <= 992) {
                        sidebar.classList.remove('show');
                        if(overlay) overlay.classList.remove('show');
                        syncBodyLock();
                    } else {
                        sidebar.classList.toggle('collapsed');
                        localStorage.setItem('sidebar-collapsed-teacher', sidebar.classList.contains('collapsed'));
                    }
                };
            }

            if(mobileToggleBtn) {
                mobileToggleBtn.onclick = () => {
                    sidebar.classList.toggle('show');
                    if(overlay) overlay.classList.toggle('show');
                    syncBodyLock();
                };
            }
            
            if(overlay) {
                overlay.onclick = () => { 
                    sidebar.classList.remove('show'); 
                    overlay.classList.remove('show');
                    syncBodyLock();
                };
            }

            window.addEventListener('resize', () => {
                if (window.innerWidth > 992) {
                    sidebar.classList.remove('show');
                    if(overlay) overlay.classList.remove('show');
                    document.body.classList.remove('sb-open');
                }
            });
        }
    });

    // Back to Top Logic
    const scrollBtn = document.getElementById('scrollTopBtn');
    const circle = document.querySelector('.progress-ring__circle');
    
    if (scrollBtn && circle) {
        const radius = circle.r.baseVal.value;
        const circumference = radius * 2 * Math.PI;
        
        circle.style.strokeDasharray = `${circumference} ${circumference}`;
        circle.style.strokeDashoffset = circumference;
        
        const updateProgress = () => {
            const scrollTop = window.scrollY;
            const docHeight = Math.max(
                document.body.scrollHeight, document.documentElement.scrollHeight,
                document.body.offsetHeight, document.documentElement.offsetHeight,
                document.body.clientHeight, document.documentElement.clientHeight
            ) - window.innerHeight;
            
            // Show/hide button
            if (scrollTop > 150) {
                scrollBtn.classList.add('show');
            } else {
                scrollBtn.classList.remove('show');
            }
            
            // Update progress ring
            if (docHeight > 0) {
                const scrollPercent = scrollTop / docHeight;
                const offset = circumference - (scrollPercent * circumference);
                circle.style.strokeDashoffset = offset;
            }
        };

        window.addEventListener('scroll', updateProgress, { passive: true });
        // Initial call in case page is refreshed while scrolled down
        updateProgress();

        scrollBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
</script>
<?php echo $__env->make('partials.sweetalert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->yieldPushContent('modals'); ?>
<?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html>
<?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/layouts/teacher.blade.php ENDPATH**/ ?>