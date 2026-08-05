<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="description" content="Teacher Dashboard — University OBE File Management System">
    <title><?php echo $__env->yieldContent('title', 'Dashboard — TeacherHub OBE'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/teacher.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

<button class="sb-toggler" id="toggleBtn" aria-label="Toggle sidebar"><i class="fas fa-bars"></i></button>
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
    <?php echo $__env->make('layouts.partials.teacher-footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
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
    });
</script>
<?php echo $__env->make('partials.sweetalert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html>
<?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/layouts/teacher.blade.php ENDPATH**/ ?>