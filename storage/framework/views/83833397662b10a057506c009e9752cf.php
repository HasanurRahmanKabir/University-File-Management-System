<?php $__env->startSection('title', 'My Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12 col-md-8 mx-auto">
            <div class="card shadow-sm border-0" style="border-radius: var(--radius-lg);">
                <div class="card-body text-center p-3 p-md-5">
                    <?php
                        $initials = strtoupper(substr($user->name, 0, 2));
                        $role = ucfirst($user->role ?? 'Administrator');
                    ?>
                    <div class="avatar-lg mx-auto mb-4" style="width: 100px; height: 100px; font-size: 36px;">
                        <?php echo e($initials); ?>

                    </div>
                    <h2 class="fw-bold mb-1 text-wrap" style="color: var(--text-heading); word-break: break-word;"><?php echo e($user->name); ?></h2>
                    <p class="text-muted mb-4" style="font-size: 1.1rem; word-break: break-all;"><?php echo e($user->email); ?></p>
                    
                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill" style="font-size: 0.9rem;">
                        <i class="fas fa-shield-alt me-1"></i> <?php echo e($role); ?>

                    </span>
                    
                    <div class="mt-5 d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="<?php echo e(route('admin.account-settings')); ?>" class="btn btn-primary px-4 py-2 w-100 w-sm-auto text-wrap" style="border-radius: var(--radius-md);">
                            <i class="fas fa-cog me-2"></i> Edit Account Settings
                        </a>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-light px-4 py-2 w-100 w-sm-auto text-wrap" style="border-radius: var(--radius-md);">
                            <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views\admin\profile.blade.php ENDPATH**/ ?>