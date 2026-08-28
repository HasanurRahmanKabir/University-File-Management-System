<?php $__env->startSection('title', 'Account Settings — StudentHub OBE'); ?>
<?php $__env->startSection('page-title', 'Account Settings'); ?>
<?php $__env->startSection('breadcrumb', 'Account Settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-hero">
    <div><div class="p-hero-h">Account Settings</div><div class="p-hero-sub">Update your personal details and password</div></div>
    <a href="<?php echo e(route('student.profile')); ?>" class="btn-primary" style="background: var(--bg-muted); color: var(--tx-h); box-shadow: none; border: 1px solid var(--bd-lt);"><i class="fas fa-arrow-left"></i> Back to Profile</a>
</div>

<div class="d-card" style="animation-delay:.05s; max-width: 900px; margin: 0 auto 30px;">
    <!-- Cover Background -->
    <div style="height: 120px; background: linear-gradient(135deg, rgba(37,99,235,0.1), rgba(59,130,246,0.15)); position: relative; border-bottom: 1px solid var(--bd-lt); border-top-left-radius: var(--r-lg); border-top-right-radius: var(--r-lg);">
    </div>
    
    <div class="profile-hdr-wrapper">
        <?php
            $name = $user->name ?? 'Student';
            $words = array_filter(explode(' ', trim($name)));
            $initials = strtoupper(substr(array_shift($words), 0, 1));
            if (!empty($words)) {
                $initials .= strtoupper(substr(array_shift($words), 0, 1));
            }
        ?>
        <div class="profile-hdr-flex">
            <div class="profile-avatar-circle" style="overflow: hidden;">
                <?php if($user->profile_image): ?>
                    <img src="<?php echo e(asset('storage/' . $user->profile_image)); ?>" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
                <?php else: ?>
                    <?php echo e($initials); ?>

                <?php endif; ?>
            </div>
            <div class="profile-name-block">
                <h3 style="margin: 0 0 6px; color: var(--tx-h); font-weight: 800; font-size: 1.5rem; letter-spacing: -0.5px;">Update Account</h3>
                <p style="margin: 0; color: var(--tx-m); font-size: 0.95rem;">Manage your personal information and security preferences.</p>
            </div>
        </div>
    </div>

    <form action="<?php echo e(route('student.settings.update')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        
        <div class="d-card-body" style="padding: 30px;">
            <!-- Profile Picture Section -->
            <div style="background: var(--bg-card); border: 1px solid var(--bd-lt); border-radius: var(--r-md); padding: 25px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid var(--bd-lt); padding-bottom: 15px; margin-bottom: 24px;">
                    <h6 style="color: var(--tx-h); font-weight: 700; margin: 0; font-size: 1.05rem; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-camera" style="color: var(--primary);"></i> Profile Picture
                    </h6>
                    <?php if($user->profile_image): ?>
                        <button type="button" onclick="document.getElementById('remove_image_input').value='1'; this.innerHTML='<i class=\'fas fa-times-circle\'></i> Marked for removal'; this.style.opacity='0.6'; this.disabled=true; this.style.pointerEvents='none';" class="btn" style="color: var(--danger); font-size: 0.8rem; font-weight: 700; border: 1px solid rgba(220,38,38,0.2); background: rgba(220,38,38,0.05); padding: 6px 12px; border-radius: var(--r-sm); transition: all 0.2s;">
                            <i class="fas fa-trash-alt"></i> Remove Picture
                        </button>
                    <?php endif; ?>
                </div>
                
                <input type="hidden" name="remove_image" id="remove_image_input" value="0">
                
                <div class="row g-4">
                    <div class="col-md-12">
                        <label style="display: block; font-size: 0.8rem; color: var(--tx-m); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Upload New Picture</label>
                        <div style="position: relative;">
                            <input type="file" name="profile_image" class="form-control" accept="image/*"
                                   style="border-radius: var(--r-sm); border: 1px solid var(--bd-lt); padding: 10px 15px; font-size: 0.95rem; color: var(--tx-h); background: #f8fafc; transition: all 0.2s; width: 100%;">
                        </div>
                        <small style="color: var(--tx-s); font-size: 0.75rem; margin-top: 6px; display: block;"><i class="fas fa-info-circle"></i> Recommended size: 200x200px. Max size: 2MB. Formats: JPG, PNG, GIF.</small>
                    </div>
                </div>
            </div>

            <!-- Personal Information Section -->
            <div style="background: var(--bg-card); border: 1px solid var(--bd-lt); border-radius: var(--r-md); padding: 25px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                <h6 style="color: var(--tx-h); font-weight: 700; margin-bottom: 24px; font-size: 1.05rem; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid var(--bd-lt); padding-bottom: 15px;">
                    <i class="fas fa-user-edit" style="color: var(--primary);"></i> Personal Information
                </h6>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <label style="display: block; font-size: 0.8rem; color: var(--tx-m); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Full Name <span style="color:var(--danger)">*</span></label>
                        <div style="position: relative;">
                            <i class="fas fa-user" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--tx-s);"></i>
                            <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required 
                                   style="border-radius: var(--r-sm); border: 1px solid var(--bd-lt); padding: 12px 15px 12px 42px; font-size: 0.95rem; color: var(--tx-h); background: #f8fafc; transition: all 0.2s;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label style="display: block; font-size: 0.8rem; color: var(--tx-m); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Email Address <span style="color:var(--danger)">*</span></label>
                        <div style="position: relative;">
                            <i class="fas fa-envelope" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--tx-s);"></i>
                            <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>" required 
                                   style="border-radius: var(--r-sm); border: 1px solid var(--bd-lt); padding: 12px 15px 12px 42px; font-size: 0.95rem; color: var(--tx-h); background: #f8fafc; transition: all 0.2s;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label style="display: block; font-size: 0.8rem; color: var(--tx-m); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Contact Number</label>
                        <div style="position: relative;">
                            <i class="fas fa-phone-alt" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--tx-s);"></i>
                            <input type="text" name="contact_number" class="form-control" value="<?php echo e(old('contact_number', $user->contact_number)); ?>" placeholder="e.g. +880 1XXX-XXXXXX"
                                   style="border-radius: var(--r-sm); border: 1px solid var(--bd-lt); padding: 12px 15px 12px 42px; font-size: 0.95rem; color: var(--tx-h); background: #f8fafc; transition: all 0.2s;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label style="display: block; font-size: 0.8rem; color: var(--tx-m); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Student ID</label>
                        <div style="position: relative;">
                            <i class="fas fa-id-badge" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--tx-s);"></i>
                            <input type="text" class="form-control" value="<?php echo e($user->student_id ?? 'N/A'); ?>" disabled 
                                   style="border-radius: var(--r-sm); border: 1px dashed var(--bd); padding: 12px 15px 12px 42px; font-size: 0.95rem; color: var(--tx-m); background: #f1f5f9; cursor: not-allowed;">
                        </div>
                        <small style="color: var(--tx-s); font-size: 0.75rem; margin-top: 6px; display: block;"><i class="fas fa-info-circle"></i> Student ID can only be updated by Admin.</small>
                    </div>
                </div>
            </div>

            <!-- Security Section -->
            <div style="background: var(--bg-card); border: 1px solid var(--bd-lt); border-radius: var(--r-md); padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                <h6 style="color: var(--tx-h); font-weight: 700; margin-bottom: 24px; font-size: 1.05rem; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid var(--bd-lt); padding-bottom: 15px;">
                    <i class="fas fa-shield-alt" style="color: var(--primary);"></i> Security & Password
                </h6>
                
                <div class="row g-4">
                    <div class="col-md-12">
                        <label style="display: block; font-size: 0.8rem; color: var(--tx-m); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Current Password</label>
                        <div style="position: relative;">
                            <i class="fas fa-lock" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--tx-s);"></i>
                            <input type="password" name="current_password" class="form-control" placeholder="Enter current password to make changes" 
                                   style="border-radius: var(--r-sm); border: 1px solid var(--bd-lt); padding: 12px 15px 12px 42px; font-size: 0.95rem; color: var(--tx-h); background: #f8fafc; transition: all 0.2s;">
                        </div>
                        <small style="color: var(--tx-s); font-size: 0.75rem; margin-top: 6px; display: block;"><i class="fas fa-info-circle"></i> Leave blank if you don't want to change your password.</small>
                    </div>
                    <div class="col-md-6">
                        <label style="display: block; font-size: 0.8rem; color: var(--tx-m); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">New Password</label>
                        <div style="position: relative;">
                            <i class="fas fa-key" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--tx-s);"></i>
                            <input type="password" name="password" class="form-control" placeholder="Enter new password" 
                                   style="border-radius: var(--r-sm); border: 1px solid var(--bd-lt); padding: 12px 15px 12px 42px; font-size: 0.95rem; color: var(--tx-h); background: #f8fafc; transition: all 0.2s;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label style="display: block; font-size: 0.8rem; color: var(--tx-m); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Confirm New Password</label>
                        <div style="position: relative;">
                            <i class="fas fa-check-double" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--tx-s);"></i>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Re-type new password" 
                                   style="border-radius: var(--r-sm); border: 1px solid var(--bd-lt); padding: 12px 15px 12px 42px; font-size: 0.95rem; color: var(--tx-h); background: #f8fafc; transition: all 0.2s;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="settings-footer">
            <a href="<?php echo e(route('student.profile')); ?>" class="btn settings-btn-cancel"><i class="fas fa-times" style="margin-right: 6px;"></i> Cancel</a>
            <button type="submit" class="btn-primary settings-btn-save"><i class="fas fa-save" style="margin-right: 8px;"></i> Save Changes</button>
        </div>
    </form>
</div>

<style>
    /* Add focus styling for inputs to match premium theme */
    .form-control:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
        outline: none !important;
    }
    
    .settings-footer {
        padding: 24px 30px;
        background: rgba(248,250,252,0.8);
        border-top: 1px solid var(--bd-lt);
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        border-bottom-left-radius: var(--r-lg);
        border-bottom-right-radius: var(--r-lg);
    }
    .settings-btn-cancel {
        padding: 12px 24px;
        border-radius: var(--r-sm);
        font-size: 0.9rem;
        font-weight: 700;
        color: #4b5563;
        background: #f3f4f6;
        border: 1px solid #d1d5db;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.2s;
    }
    .settings-btn-cancel:hover {
        background: #e5e7eb;
        color: #1f2937;
        border-color: #9ca3af;
    }
    .settings-btn-save {
        padding: 12px 30px;
        border-radius: var(--r-sm);
        font-size: 0.9rem;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(37,99,235,0.25);
    }
    
    /* Profile specific responsive styles */
    .profile-hdr-wrapper {
        padding: 0 30px 25px;
        border-bottom: 1px solid var(--bd-lt);
        background: transparent;
        position: relative;
        z-index: 10;
    }
    .profile-hdr-flex {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 20px;
    }
    .profile-avatar-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 2.5rem;
        font-weight: 800;
        border: 4px solid #fff;
        box-shadow: 0 4px 15px rgba(37,99,235,0.25);
        flex-shrink: 0;
        margin-top: -60px;
    }
    .profile-name-block {
        padding-top: 10px;
    }
    
    @media (max-width: 576px) {
        .profile-hdr-wrapper {
            padding: 0 15px 20px;
        }
        .profile-hdr-flex {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }
        .profile-name-block {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .profile-name-block > div {
            justify-content: center !important;
        }
        .hide-mobile {
            display: none !important;
        }
        .settings-footer {
            flex-direction: column-reverse;
            padding: 20px 15px;
            gap: 12px;
        }
        .settings-btn-cancel, .settings-btn-save {
            width: 100%;
            text-align: center;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views\student\settings.blade.php ENDPATH**/ ?>