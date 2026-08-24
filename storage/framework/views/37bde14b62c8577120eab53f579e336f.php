<?php $__env->startSection('title', 'Account Settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold" style="color: var(--text-heading);">Account Settings</h3>
            <p class="text-muted">Manage your profile details and password.</p>
        </div>
    </div>



    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card shadow-sm border-0 mb-4" style="border-radius: var(--radius-lg);">
                <div class="card-body p-4 p-md-5">
                    <form action="<?php echo e(route('admin.account-settings.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <h5 class="fw-bold mb-4" style="color: var(--primary);"><i class="fas fa-user me-2"></i> Personal Information</h5>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('name', $user->name)); ?>" required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email', $user->email)); ?>" required>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <hr class="my-5">

                        <h5 class="fw-bold mb-4" style="color: var(--primary);"><i class="fas fa-lock me-2"></i> Security (Optional)</h5>
                        <p class="text-muted small mb-4">Leave these fields blank if you do not wish to change your password.</p>

                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Current Password</label>
                                <div class="form-control d-flex align-items-center p-0 <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" style="overflow: hidden; background-color: var(--bg-card);">
                                    <input type="password" name="current_password" id="current_password" class="border-0 bg-transparent flex-grow-1 m-0" placeholder="Current password" style="outline: none; padding: 10px 15px; min-width: 0; box-shadow: none;">
                                    <button class="btn border-0 text-muted m-0 d-flex align-items-center justify-content-center" type="button" onclick="togglePassword('current_password', this)" style="background: transparent; box-shadow: none; padding: 0 15px; height: 100%; min-width: 45px;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-12 col-md-6 d-none d-md-block"></div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">New Password</label>
                                <div class="form-control d-flex align-items-center p-0 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" style="overflow: hidden; background-color: var(--bg-card);">
                                    <input type="password" name="password" id="new_password" class="border-0 bg-transparent flex-grow-1 m-0" placeholder="Min 8 chars" style="outline: none; padding: 10px 15px; min-width: 0; box-shadow: none;">
                                    <button class="btn border-0 text-muted m-0 d-flex align-items-center justify-content-center" type="button" onclick="togglePassword('new_password', this)" style="background: transparent; box-shadow: none; padding: 0 15px; height: 100%; min-width: 45px;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Confirm New Password</label>
                                <div class="form-control d-flex align-items-center p-0" style="overflow: hidden; background-color: var(--bg-card);">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="border-0 bg-transparent flex-grow-1 m-0" placeholder="Confirm password" style="outline: none; padding: 10px 15px; min-width: 0; box-shadow: none;">
                                    <button class="btn border-0 text-muted m-0 d-flex align-items-center justify-content-center" type="button" onclick="togglePassword('password_confirmation', this)" style="background: transparent; box-shadow: none; padding: 0 15px; height: 100%; min-width: 45px;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-5">
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-light" style="border-radius: var(--radius-md);">Cancel</a>
                            <button type="submit" class="btn btn-primary" style="border-radius: var(--radius-md);">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sidebar Info Card -->
        <div class="col-12 col-xl-4">
            <div class="card shadow-sm border-0" style="border-radius: var(--radius-lg); background: linear-gradient(135deg, var(--primary), #8b5cf6); color: white;">
                <div class="card-body p-4 text-center">
                    <div class="avatar-lg mx-auto mb-3" style="width: 80px; height: 80px; font-size: 32px; background: rgba(255,255,255,0.2); box-shadow: none;">
                        <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

                    </div>
                    <h5 class="fw-bold mb-1"><?php echo e($user->name); ?></h5>
                    <p class="mb-3 opacity-75"><?php echo e(ucfirst($user->role ?? 'Administrator')); ?></p>
                    <hr class="border-light opacity-25 my-3">
                    <p class="small mb-0 opacity-75">Member since <?php echo e($user->created_at->format('M d, Y')); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId, btn) {
        const field = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views\admin\account-settings.blade.php ENDPATH**/ ?>