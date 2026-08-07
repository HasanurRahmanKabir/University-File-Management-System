<header class="topbar">
    <div class="tb-left">
        <div class="tb-title"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></div>
        <div class="tb-breadcrumb">
            <span><a href="<?php echo e(route('student.dashboard')); ?>">Home</a></span>
            <span><i class="fas fa-chevron-right" style="font-size:.5rem;color:#d1d5db;"></i></span>
            <span><?php echo $__env->yieldContent('breadcrumb', 'Dashboard'); ?></span>
        </div>
    </div>
    <div class="tb-right">
        <div class="tb-user-info d-none d-sm-block">
            <div class="tb-uname"><?php echo e(Auth::user()->name ?? 'Student'); ?></div>
            <div class="tb-urole">Student</div>
        </div>
        <div class="tb-avatar">
            <?php if(Auth::user() && Auth::user()->profile_image): ?>
                <img src="<?php echo e(asset('storage/' . Auth::user()->profile_image)); ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
            <?php else: ?>
                <?php echo e(strtoupper(substr(Auth::user()->name ?? 'S', 0, 2))); ?>

            <?php endif; ?>
        </div>
    </div>
</header>
<?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/layouts/partials/student-topbar.blade.php ENDPATH**/ ?>