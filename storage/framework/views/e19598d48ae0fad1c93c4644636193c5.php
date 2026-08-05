<header class="topbar">
    <div>
        <div class="tb-title"><?php echo $__env->yieldContent('page_title', 'Dashboard'); ?></div>
        <div class="tb-breadcrumb">
            <a href="<?php echo e(route('teacher.dashboard')); ?>">Home</a>
            <span>/</span>
            <span><?php echo $__env->yieldContent('page_title', 'Dashboard'); ?></span>
        </div>
    </div>
    <div class="tb-right">
        <div class="d-none d-sm-block" style="text-align:right;">
            <div class="tb-uname"><?php echo e(Auth::user()->name ?? 'Teacher Name'); ?></div>
            <div class="tb-urole"><?php echo e(Auth::user()->designation ?? 'Teacher'); ?></div>
        </div>
        <div class="tb-avatar"><?php echo e(strtoupper(substr(Auth::user()->name ?? 'T', 0, 2))); ?></div>
    </div>
</header>
<?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/layouts/partials/teacher-topbar.blade.php ENDPATH**/ ?>