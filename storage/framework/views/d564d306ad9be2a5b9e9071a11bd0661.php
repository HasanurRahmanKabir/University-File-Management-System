<?php $__env->startSection('title', 'System Settings - Admin Dashboard'); ?>
<?php $__env->startSection('page-title', 'System Settings'); ?>
<?php $__env->startSection('breadcrumb', 'Settings'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .file-upload-wrapper {
        position: relative;
        border: 2px dashed var(--border);
        border-radius: var(--radius-md);
        padding: 20px;
        text-align: center;
        background: var(--bg-input);
        transition: all var(--duration-base) var(--ease);
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 140px;
    }
    .file-upload-wrapper:hover {
        border-color: var(--primary);
        background: rgba(79, 70, 229, 0.02);
    }
    .file-upload-icon {
        font-size: 2rem;
        color: var(--text-muted);
        margin-bottom: 10px;
    }
    .file-upload-text {
        color: var(--text-secondary);
        font-size: 0.85rem;
        font-weight: 500;
    }
    .file-upload-input {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        z-index: 10;
    }
    .preview-container {
        position: relative;
        z-index: 20;
    }
    .preview-logo {
        max-width: 100%;
        max-height: 140px;
        object-fit: contain;
        background: white;
        border-radius: 8px;
        box-shadow: var(--shadow-sm);
        padding: 5px;
    }
    .remove-logo-btn {
        position: absolute;
        top: -10px;
        right: -10px;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.75rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('admin.system-settings.update')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div class="heading-group m-0">
            <h2>Configuration</h2>
            <p class="text-muted m-0">Manage global branding, dashboard identities, and system preferences.</p>
        </div>
    </div>


    <div class="row g-4 mt-2">
        <!-- Global Branding -->
        <div class="col-xl-6">
            <div class="data-card h-100 m-0">
                <div class="card-header"><h5 class="card-title"><i class="fas fa-globe text-primary"></i> Global Identity & Branding</h5></div>
                <div class="card-body p-4">
                    <div class="form-group">
                        <label class="form-label">Brand Tagline (Appears under dashboard name in sidebar)</label>
                        <input type="text" name="brand_tagline" class="form-input" value="<?php echo e($settings['brand_tagline'] ?? ''); ?>">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Footer Copyright Text</label>
                        <input type="text" name="footer_copyright" class="form-input" value="<?php echo e($settings['footer_copyright'] ?? ''); ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- System Preferences -->
        <div class="col-xl-6">
            <div class="data-card h-100 m-0">
                <div class="card-header"><h5 class="card-title"><i class="fas fa-sliders text-success"></i> System Preferences</h5></div>
                <div class="card-body p-4">
                    <div class="form-group">
                        <label class="form-label">System Contact Email Address</label>
                        <input type="email" name="system_email" class="form-input" value="<?php echo e($settings['system_email'] ?? ''); ?>">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Current Academic Session</label>
                        <input type="text" name="academic_session" class="form-input" value="<?php echo e($settings['academic_session'] ?? ''); ?>" placeholder="e.g. 2025-2026">
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Branding Cards -->
        <div class="col-xl-4 col-md-6">
            <div class="data-card h-100 m-0">
                <div class="card-header"><h5 class="card-title"><i class="fas fa-user-shield text-danger"></i> Admin Dashboard</h5></div>
                <div class="card-body p-4">
                    <div class="form-group">
                        <label class="form-label">Dashboard Name (Appears in Sidebar)</label>
                        <input type="text" name="admin_dashboard_name" class="form-input" value="<?php echo e($settings['admin_dashboard_name'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Browser Tab Title</label>
                        <input type="text" name="admin_tab_title" class="form-input" value="<?php echo e($settings['admin_tab_title'] ?? ''); ?>">
                        <small class="text-muted" style="font-size: 0.75rem; margin-top: 4px; display: block;">This text will be displayed in the browser tab for all admin pages.</small>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Dashboard Logo</label>
                        <div class="file-upload-wrapper">
                            <input type="hidden" name="remove_admin_logo" value="0">
                            <input type="file" name="admin_logo" class="file-upload-input" accept="image/*" onchange="previewImage(this, 'admin-logo-preview')">
                            
                            <div class="file-upload-placeholder" style="<?php echo e(isset($settings['admin_logo']) && $settings['admin_logo'] ? 'display:none;' : 'display:block;'); ?>">
                                <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                                <div class="file-upload-text">Drag & drop or click to upload logo</div>
                            </div>
                            
                            <div class="preview-container" style="<?php echo e(isset($settings['admin_logo']) && $settings['admin_logo'] ? 'display:inline-block;' : 'display:none;'); ?>">
                                <button type="button" class="remove-logo-btn" onclick="removeLogo(event, this)"><i class="fas fa-times"></i></button>
                                <img id="admin-logo-preview" class="preview-logo" src="<?php echo e(isset($settings['admin_logo']) ? asset('storage/' . $settings['admin_logo']) : ''); ?>" style="display:block;" alt="Preview">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="data-card h-100 m-0">
                <div class="card-header"><h5 class="card-title"><i class="fas fa-chalkboard-teacher text-info"></i> Teacher Dashboard</h5></div>
                <div class="card-body p-4">
                    <div class="form-group">
                        <label class="form-label">Dashboard Name (Appears in Sidebar)</label>
                        <input type="text" name="teacher_dashboard_name" class="form-input" value="<?php echo e($settings['teacher_dashboard_name'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Browser Tab Title</label>
                        <input type="text" name="teacher_tab_title" class="form-input" value="<?php echo e($settings['teacher_tab_title'] ?? ''); ?>">
                        <small class="text-muted" style="font-size: 0.75rem; margin-top: 4px; display: block;">This text will be displayed in the browser tab for all teacher pages.</small>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Dashboard Logo</label>
                        <div class="file-upload-wrapper">
                            <input type="hidden" name="remove_teacher_logo" value="0">
                            <input type="file" name="teacher_logo" class="file-upload-input" accept="image/*" onchange="previewImage(this, 'teacher-logo-preview')">
                            
                            <div class="file-upload-placeholder" style="<?php echo e(isset($settings['teacher_logo']) && $settings['teacher_logo'] ? 'display:none;' : 'display:block;'); ?>">
                                <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                                <div class="file-upload-text">Drag & drop or click to upload logo</div>
                            </div>
                            
                            <div class="preview-container" style="<?php echo e(isset($settings['teacher_logo']) && $settings['teacher_logo'] ? 'display:inline-block;' : 'display:none;'); ?>">
                                <button type="button" class="remove-logo-btn" onclick="removeLogo(event, this)"><i class="fas fa-times"></i></button>
                                <img id="teacher-logo-preview" class="preview-logo" src="<?php echo e(isset($settings['teacher_logo']) ? asset('storage/' . $settings['teacher_logo']) : ''); ?>" style="display:block;" alt="Preview">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="data-card h-100 m-0">
                <div class="card-header"><h5 class="card-title"><i class="fas fa-user-graduate text-warning"></i> Student Dashboard</h5></div>
                <div class="card-body p-4">
                    <div class="form-group">
                        <label class="form-label">Dashboard Name (Appears in Sidebar)</label>
                        <input type="text" name="student_dashboard_name" class="form-input" value="<?php echo e($settings['student_dashboard_name'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Browser Tab Title</label>
                        <input type="text" name="student_tab_title" class="form-input" value="<?php echo e($settings['student_tab_title'] ?? ''); ?>">
                        <small class="text-muted" style="font-size: 0.75rem; margin-top: 4px; display: block;">This text will be displayed in the browser tab for all student pages.</small>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Dashboard Logo</label>
                        <div class="file-upload-wrapper">
                            <input type="hidden" name="remove_student_logo" value="0">
                            <input type="file" name="student_logo" class="file-upload-input" accept="image/*" onchange="previewImage(this, 'student-logo-preview')">
                            
                            <div class="file-upload-placeholder" style="<?php echo e(isset($settings['student_logo']) && $settings['student_logo'] ? 'display:none;' : 'display:block;'); ?>">
                                <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                                <div class="file-upload-text">Drag & drop or click to upload logo</div>
                            </div>
                            
                            <div class="preview-container" style="<?php echo e(isset($settings['student_logo']) && $settings['student_logo'] ? 'display:inline-block;' : 'display:none;'); ?>">
                                <button type="button" class="remove-logo-btn" onclick="removeLogo(event, this)"><i class="fas fa-times"></i></button>
                                <img id="student-logo-preview" class="preview-logo" src="<?php echo e(isset($settings['student_logo']) ? asset('storage/' . $settings['student_logo']) : ''); ?>" style="display:block;" alt="Preview">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Auth / Login Page Branding -->
        <div class="col-12">
            <div class="data-card m-0">
                <div class="card-header"><h5 class="card-title"><i class="fas fa-right-to-bracket text-secondary"></i> Login Page Branding</h5></div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Login Page Title (Main Heading)</label>
                                <input type="text" name="login_title" class="form-input" value="<?php echo e($settings['login_title'] ?? ''); ?>" placeholder="e.g. Welcome Back!">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Browser Tab Title</label>
                                <input type="text" name="login_tab_title" class="form-input" value="<?php echo e($settings['login_tab_title'] ?? ''); ?>">
                                <small class="text-muted" style="font-size: 0.75rem; margin-top: 4px; display: block;">This text will appear in the browser tab on the login screen.</small>
                            </div>
                            <div class="form-group mb-lg-0">
                                <label class="form-label">Login Page Subtitle (Used for SEO Meta Description too)</label>
                                <input type="text" name="login_subtitle" class="form-input" value="<?php echo e($settings['login_subtitle'] ?? ''); ?>" placeholder="e.g. Enter your credentials to access the portal">
                            </div>
                            <div class="form-group mt-3 mb-lg-0">
                                <label class="form-label">Login Logo Tagline</label>
                                <input type="text" name="login_logo_tagline" class="form-input" value="<?php echo e($settings['login_logo_tagline'] ?? ''); ?>" placeholder="e.g. University File Management System">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-0">
                                <label class="form-label">Login Page Logo</label>
                                <div class="file-upload-wrapper">
                                    <input type="hidden" name="remove_login_logo" value="0">
                                    <input type="file" name="login_logo" class="file-upload-input" accept="image/*" onchange="previewImage(this, 'login-logo-preview')">
                                    
                                    <div class="file-upload-placeholder" style="<?php echo e(isset($settings['login_logo']) && $settings['login_logo'] ? 'display:none;' : 'display:block;'); ?>">
                                        <i class="fas fa-image file-upload-icon"></i>
                                        <div class="file-upload-text">Upload the main logo for the login screen</div>
                                    </div>
                                    
                                    <div class="preview-container" style="<?php echo e(isset($settings['login_logo']) && $settings['login_logo'] ? 'display:inline-block;' : 'display:none;'); ?>">
                                        <button type="button" class="remove-logo-btn" onclick="removeLogo(event, this)"><i class="fas fa-times"></i></button>
                                        <img id="login-logo-preview" class="preview-logo" src="<?php echo e(isset($settings['login_logo']) ? asset('storage/' . $settings['login_logo']) : ''); ?>" style="display:block;" alt="Preview">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4 text-end">
            <button type="submit" class="btn btn-primary px-4 py-2" style="font-weight: 600;"><i class="fas fa-save me-2"></i> Save All Changes</button>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const wrapper = input.closest('.file-upload-wrapper');
        const placeholder = wrapper.querySelector('.file-upload-placeholder');
        const previewContainer = wrapper.querySelector('.preview-container');
        const removeInput = wrapper.querySelector('input[type="hidden"]');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
                placeholder.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
            removeInput.value = '0';
        }
    }

    function removeLogo(e, btn) {
        e.preventDefault();
        e.stopPropagation();
        
        const wrapper = btn.closest('.file-upload-wrapper');
        const fileInput = wrapper.querySelector('input[type="file"]');
        const removeInput = wrapper.querySelector('input[type="hidden"]');
        const placeholder = wrapper.querySelector('.file-upload-placeholder');
        const previewContainer = wrapper.querySelector('.preview-container');
        const previewImg = wrapper.querySelector('.preview-logo');
        
        if(fileInput) fileInput.value = '';
        removeInput.value = '1';
        
        previewContainer.style.display = 'none';
        placeholder.style.display = 'block';
        previewImg.src = '';
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views\admin\system-settings.blade.php ENDPATH**/ ?>