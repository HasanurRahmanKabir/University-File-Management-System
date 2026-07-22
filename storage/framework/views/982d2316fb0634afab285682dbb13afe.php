<?php $__env->startSection('title', 'Course Files - Admin Dashboard'); ?>
<?php $__env->startSection('page-title', 'Course Materials'); ?>
<?php $__env->startSection('breadcrumb', 'Course Files'); ?>

<?php $__env->startPush('styles'); ?>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
    /* Ensure TomSelect perfectly matches the standard form-select design */
    .ts-wrapper.form-select {
        padding: 0 !important;
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
    }
    .ts-control {
        border: 1.5px solid var(--border) !important;
        border-radius: var(--radius-md) !important;
        background: var(--bg-input) !important;
        color: var(--text-body) !important;
        font-size: 0.85rem !important;
        padding: 9px 13px !important;
        min-height: 42px !important;
        box-shadow: var(--shadow-sm) !important; /* Restored Shadow as per user request */
        display: flex;
        align-items: center;
        transition: all var(--duration-base) var(--ease);
    }
    .ts-wrapper.focus .ts-control {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px var(--primary-glow) !important;
        background: white !important;
        outline: none !important;
    }
    /* Bulletproof placeholders to prevent blank boxes */
    .ts-wrapper.ts-faculty:not(.has-items) .ts-control::before {
        content: "Select Faculty";
        display: block !important;
        color: var(--text-secondary) !important;
        font-weight: 500 !important;
    }
    .ts-wrapper.ts-course:not(.has-items) .ts-control::before {
        content: "Select Course";
        display: block !important;
        color: var(--text-secondary) !important;
        font-weight: 500 !important;
    }
    
    /* Ensure TomSelect's actual item also stays visible and bold if it's there */
    .ts-control .item[data-value=""] {
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
        color: var(--text-secondary) !important;
        font-weight: 500 !important;
    }
    
    /* If the placeholder is showing via ::before, hide the .item to avoid double text */
    .ts-wrapper:not(.has-items) .ts-control .item[data-value=""] {
        display: none !important;
    }
    
    .ts-dropdown {
        border: 1px solid var(--border) !important;
        border-radius: var(--radius-md) !important;
        background-color: white !important; /* Fixed: Solid white background */
        box-shadow: var(--shadow-md) !important;
        z-index: 9999 !important;
    }
    /* Hide the placeholder option from the dropdown list */
    .ts-dropdown .option[data-value=""] {
        display: none !important;
    }
    .ts-dropdown .option {
        padding: 8px 14px !important;
        color: var(--text-body) !important;
        font-size: 0.85rem !important;
    }
    .ts-dropdown .option:hover, .ts-dropdown .active {
        background-color: var(--bg-muted) !important;
        color: var(--primary) !important;
    }
    .ts-dropdown .dropdown-input-wrap {
        padding: 8px !important;
        border-bottom: 1px solid var(--border-light) !important;
    }
    .ts-dropdown .dropdown-input {
        border: 1px solid var(--border) !important;
        border-radius: var(--radius-sm) !important;
        padding: 6px 12px !important;
        background: var(--bg-muted) !important;
        color: var(--text-body) !important;
        font-size: 0.85rem !important;
    }
    /* Add the dropdown arrow back since we hid the default select */
    .ts-control::after {
        content: "";
        display: block;
        width: 10px;
        height: 10px;
        border-right: 2px solid #888;
        border-bottom: 2px solid #888;
        transform: rotate(45deg);
        position: absolute;
        right: 15px;
        top: 40%;
        transition: transform 0.2s ease;
    }
    .ts-wrapper.dropdown-active .ts-control::after {
        transform: rotate(-135deg);
        top: 45%;
    }
    /* Keep the selected item or placeholder visible when dropdown is open */
    .ts-wrapper.dropdown-active .ts-control .item, 
    .ts-wrapper.has-items .ts-control .item {
        display: block !important;
        opacity: 1 !important;
    }
    /* Ensure the dropdown scroll works for thousands of items */
    .ts-dropdown .ts-dropdown-content {
        max-height: 250px;
        overflow-y: auto;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div class="heading-group">
        <h2>Uploaded Course Materials</h2>
        <p>View and manage all course files uploaded by faculty members.</p>
    </div>
    <div style="display:flex; gap:8px; margin-right: 15px;">
        <button class="btn btn-primary mt-2 mt-sm-0" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <i class="fas fa-cloud-upload-alt"></i> Upload Material
        </button>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid grid-3">
    <div class="stat-card">
        <div class="stat-icon-wrap blue"><i class="fas fa-file-lines"></i></div>
        <div class="stat-info">
            <div class="stat-label">Total Files</div>
            <div class="stat-number"><?php echo e($totalFiles); ?></div>
            <div class="stat-trend up"><i class="fas fa-arrow-up"></i> <?php echo e($weeklyFiles); ?> this week</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrap rose"><i class="fas fa-file-pdf"></i></div>
        <div class="stat-info">
            <div class="stat-label">PDF Documents</div>
            <div class="stat-number"><?php echo e($pdfCount); ?></div>
            <div class="stat-trend neutral"><i class="fas fa-check"></i> <?php echo e($pdfPercentage); ?>% of files</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrap emerald"><i class="fas fa-hard-drive"></i></div>
        <div class="stat-info">
            <div class="stat-label">Storage Used</div>
            <div class="stat-number"><?php echo e($storageUsed); ?></div>
            <div class="stat-trend neutral"><i class="fas fa-database"></i> of 10 GB</div>
        </div>
    </div>
</div>

<div class="data-card">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5 class="card-title"><i class="fas fa-folder-open"></i> Teacher's Uploaded Files</h5>
            <p class="card-subtitle">All course materials with file types</p>
        </div>
        <form action="<?php echo e(route('admin.course-files.index')); ?>" method="GET" class="d-flex align-items-center gap-2" id="searchForm">
            <div class="search-box position-relative">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" id="searchInput" placeholder="Search any field..." value="<?php echo e(request('search')); ?>" style="padding-right: 30px;">
                <?php if(request('search')): ?>
                    <button type="button" class="btn-clear-search" onclick="window.location.href='<?php echo e(route('admin.course-files.index')); ?>'" title="Clear Search">
                        <i class="fas fa-times"></i>
                    </button>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem;"><i class="fas fa-search"></i> Search</button>
        </form>
    </div>
    <div class="card-body">
        <div class="table-wrap table-responsive">
            <table class="premium-table w-100">
                <thead>
                    <tr>
                        <th>Teacher</th>
                        <th>Course</th>
                        <th>Title</th>
                        <th>File</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="user-cell">
                                <?php
                                    $uploaderName = $material->uploader->name ?? 'Unknown';
                                    $initials = strtoupper(substr($uploaderName, 0, 2));
                                    $colors = ['emerald', 'cyan', 'rose', 'blue', 'amber', 'purple', 'indigo'];
                                    $colorClass = $colors[strlen($uploaderName) % count($colors)];
                                ?>
                                <div class="avatar-sm <?php echo e($colorClass); ?>"><?php echo e($initials); ?></div>
                                <div>
                                    <div class="user-name"><?php echo e($uploaderName); ?></div>
                                    <div class="user-sub"><?php echo e($material->uploader->role ?? 'User'); ?></div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge dark"><?php echo e($material->course->course_code ?? 'N/A'); ?></span></td>
                        <td>
                            <div class="user-name"><?php echo e($material->title); ?></div>
                            <div class="user-sub">Uploaded <?php echo e($material->created_at->diffForHumans()); ?></div>
                        </td>
                        <td>
                            <?php
                                $ext = strtolower($material->file_type ?? 'pdf');
                                $icon = 'fa-file-alt';
                                $badgeClass = 'primary';
                                
                                if (in_array($ext, ['pdf'])) {
                                    $icon = 'fa-file-pdf';
                                    $badgeClass = 'danger';
                                } elseif (in_array($ext, ['doc', 'docx'])) {
                                    $icon = 'fa-file-word';
                                    $badgeClass = 'info';
                                } elseif (in_array($ext, ['xls', 'xlsx', 'csv'])) {
                                    $icon = 'fa-file-excel';
                                    $badgeClass = 'success';
                                } elseif (in_array($ext, ['ppt', 'pptx'])) {
                                    $icon = 'fa-file-powerpoint';
                                    $badgeClass = 'rose';
                                } elseif (in_array($ext, ['zip', 'rar', '7z'])) {
                                    $icon = 'fa-file-archive';
                                    $badgeClass = 'warning';
                                } elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                                    $icon = 'fa-file-image';
                                    $badgeClass = 'cyan';
                                }
                            ?>
                            <a href="<?php echo e(Storage::url($material->file_path)); ?>" target="_blank" class="badge <?php echo e($badgeClass); ?>" style="text-decoration: none; display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; font-size: 0.75rem; border-radius: var(--radius-sm); transition: all 0.2s;">
                                <i class="fas <?php echo e($icon); ?>"></i> <?php echo e(strtoupper($ext)); ?>

                            </a>
                        </td>
                        <td>
                            <div class="action-group">
                                <button class="action-btn edit edit-btn" data-bs-toggle="modal" data-bs-target="#editFileModal"
                                    data-id="<?php echo e($material->id); ?>"
                                    data-course="<?php echo e($material->course_id); ?>"
                                    data-title="<?php echo e($material->title); ?>"
                                    data-filepath="<?php echo e($material->file_path); ?>"
                                    data-fileext="<?php echo e(strtoupper($ext)); ?>"
                                    data-teacherid="<?php echo e($material->uploaded_by); ?>">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="<?php echo e(route('admin.course-files.destroy', $material->id)); ?>" method="POST" class="m-0 p-0 delete-form d-flex align-items-center">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="button" class="action-btn delete delete-btn"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3" style="opacity: 0.2;"></i>
                                <h6 class="text-heading fw-bold">No Course Files found</h6>
                                <p class="text-muted small">Upload your first material to get started.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($materials->hasPages()): ?>
            <div class="px-4 py-3 border-top">
                <?php echo e($materials->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('modals'); ?>
<!-- UPLOAD -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content premium">
            <div class="modal-head gradient">
                <h5 class="modal-title"><i class="fas fa-cloud-upload-alt"></i> Upload Material</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <form action="<?php echo e(route('admin.course-files.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Teacher</label>
                            <select name="uploaded_by" id="add_teacher" class="form-select" required placeholder="Select Faculty">
                                <option value="">Select Faculty</option>
                                <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($teacher->id); ?>"><?php echo e($teacher->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Course</label>
                            <select name="course_id" id="add_course" class="form-select" required placeholder="Select Course">
                                <option value="">Select Course</option>
                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($course->id); ?>"><?php echo e($course->course_code); ?> - <?php echo e($course->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Material Title</label>
                        <input type="text" name="title" class="form-input" placeholder="Enter title" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Choose File</label>
                        <div class="upload-zone position-relative" id="upload_zone_container">
                            <div id="upload_default_ui">
                                <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                <p>Drag & drop your file here, or <span class="browse-link">browse</span></p>
                            </div>
                            <div id="upload_file_preview" style="display: none; padding: 10px; text-align: center;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                    <div style="font-size: 2.5rem; color: var(--primary);"><i class="fas fa-file-alt" id="preview_file_icon"></i></div>
                                    <div style="font-weight: 600; color: var(--text-heading); font-size: 0.95rem; word-break: break-all;" id="preview_file_name">filename.ext</div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);" id="preview_file_size">0 MB</div>
                                    <button type="button" class="btn btn-sm" id="btn_remove_file" style="margin-top: 8px; background: var(--danger-light); color: var(--danger); border-radius: 6px; padding: 6px 14px; font-size: 0.8rem; border: none; cursor: pointer; position: relative; z-index: 20; display: inline-flex; align-items: center; gap: 6px; font-weight: 600;">
                                        <i class="fas fa-times"></i> Remove File
                                    </button>
                                </div>
                            </div>
                            <input type="file" id="upload_file_input" name="file" class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" required style="z-index:10; cursor:pointer;">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" style="margin-top:10px;">
                        <i class="fas fa-check-circle"></i> Confirm Upload
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT FILE -->
<div class="modal fade" id="editFileModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content premium">
            <div class="modal-head dark-grad">
                <h5 class="modal-title"><i class="fas fa-pen"></i> Update Material</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <form id="editFileForm" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Teacher</label>
                            <select name="uploaded_by" id="edit_teacher_id" class="form-select" required placeholder="Select Faculty">
                                <option value="">Select Faculty</option>
                                <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($teacher->id); ?>"><?php echo e($teacher->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Course</label>
                            <select name="course_id" id="edit_course_id" class="form-select" required placeholder="Select Course">
                                <option value="">Select Course</option>
                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($course->id); ?>"><?php echo e($course->course_code); ?> - <?php echo e($course->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Update Title</label>
                        <input type="text" name="title" id="edit_title" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Replace File</label>
                        <div class="file-info-bar mb-2">
                            <i class="fas fa-file-alt" id="edit_file_icon"></i> Current: <span id="edit_file_name"></span>
                        </div>
                        <input type="file" name="file" class="form-input" style="padding:8px;">
                        <small style="color:var(--text-muted);font-size:0.75rem;margin-top:4px;display:block;">Leave empty if you don't want to change the file.</small>
                    </div>
                    <div class="form-actions mt-3">
                        <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize TomSelect for Teachers and Courses with dropdown_input plugin
        if(document.getElementById('add_teacher')) {
            let addT = new TomSelect("#add_teacher", {
                create: false,
                controlInput: null,
                maxOptions: null,
                allowEmptyOption: true,
                wrapperClass: 'ts-wrapper form-select ts-faculty',
                plugins: ['dropdown_input'],
                sortField: { field: "text", direction: "asc" }
            });
            let searchInput = addT.dropdown.querySelector('input');
            if(searchInput) searchInput.setAttribute('placeholder', 'Search faculty...');
        }
        if(document.getElementById('edit_teacher_id')) {
            window.editTeacherSelect = new TomSelect("#edit_teacher_id", {
                create: false,
                controlInput: null,
                maxOptions: null,
                allowEmptyOption: true,
                wrapperClass: 'ts-wrapper form-select ts-faculty',
                plugins: ['dropdown_input'],
                sortField: { field: "text", direction: "asc" }
            });
            let searchInput = window.editTeacherSelect.dropdown.querySelector('input');
            if(searchInput) searchInput.setAttribute('placeholder', 'Search faculty...');
        }
        if(document.getElementById('add_course')) {
            let addC = new TomSelect("#add_course", {
                create: false,
                controlInput: null,
                maxOptions: null,
                allowEmptyOption: true,
                wrapperClass: 'ts-wrapper form-select ts-course',
                plugins: ['dropdown_input'],
                sortField: { field: "text", direction: "asc" }
            });
            let searchInput = addC.dropdown.querySelector('input');
            if(searchInput) searchInput.setAttribute('placeholder', 'Search course...');
        }
        if(document.getElementById('edit_course_id')) {
            window.editCourseSelect = new TomSelect("#edit_course_id", {
                create: false,
                controlInput: null,
                maxOptions: null,
                allowEmptyOption: true,
                wrapperClass: 'ts-wrapper form-select ts-course',
                plugins: ['dropdown_input'],
                sortField: { field: "text", direction: "asc" }
            });
            let searchInput = window.editCourseSelect.dropdown.querySelector('input');
            if(searchInput) searchInput.setAttribute('placeholder', 'Search course...');
        }

        // Edit Modal Population
        const editButtons = document.querySelectorAll('.edit-btn');
        const editForm = document.getElementById('editFileForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('edit_title').value = this.getAttribute('data-title');
                
                if(window.editTeacherSelect) {
                    window.editTeacherSelect.setValue(this.getAttribute('data-teacherid'));
                }
                if(window.editCourseSelect) {
                    window.editCourseSelect.setValue(this.getAttribute('data-course'));
                }
                
                // File info display
                let filePath = this.getAttribute('data-filepath');
                let fileName = filePath ? filePath.split('/').pop() : 'No file';
                document.getElementById('edit_file_name').innerText = fileName;
                
                let ext = this.getAttribute('data-fileext');
                let iconClass = 'fa-file-alt';
                if (ext === 'PDF') iconClass = 'fa-file-pdf';
                else if (ext === 'DOC' || ext === 'DOCX') iconClass = 'fa-file-word';
                else if (ext === 'XLS' || ext === 'XLSX') iconClass = 'fa-file-excel';
                else if (ext === 'PPT' || ext === 'PPTX') iconClass = 'fa-file-powerpoint';
                else if (ext === 'ZIP' || ext === 'RAR') iconClass = 'fa-file-archive';
                
                document.getElementById('edit_file_icon').className = 'fas ' + iconClass;
                
                let actionUrl = "<?php echo e(route('admin.course-files.update', ':id')); ?>";
                editForm.action = actionUrl.replace(':id', id);
            });
        });

        // Delete Confirmation
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This file will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Toast Notifications
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            background: 'var(--bg-card)',
            color: 'var(--text-heading)',
            customClass: { popup: 'premium-toast' }
        });

        <?php if(session('success')): ?>
            Toast.fire({ icon: 'success', title: "<?php echo e(session('success')); ?>" });
        <?php endif; ?>
        <?php if(session('error')): ?>
            Toast.fire({ icon: 'error', title: "<?php echo e(session('error')); ?>" });
        <?php endif; ?>
        <?php if($errors->any()): ?>
            Toast.fire({ icon: 'error', title: "Validation Error", text: "<?php echo e($errors->first()); ?>" });
        <?php endif; ?>

        // File Upload Preview & Remove Logic
        const fileInput = document.getElementById('upload_file_input');
        const defaultUI = document.getElementById('upload_default_ui');
        const previewUI = document.getElementById('upload_file_preview');
        const previewName = document.getElementById('preview_file_name');
        const previewSize = document.getElementById('preview_file_size');
        const previewIcon = document.getElementById('preview_file_icon');
        const removeBtn = document.getElementById('btn_remove_file');

        if(fileInput) {
            fileInput.addEventListener('change', function() {
                if(this.files && this.files.length > 0) {
                    const file = this.files[0];
                    previewName.textContent = file.name;
                    
                    let size = file.size;
                    let sizeStr = '';
                    if(size < 1024) sizeStr = size + ' B';
                    else if(size < 1024 * 1024) sizeStr = (size / 1024).toFixed(1) + ' KB';
                    else sizeStr = (size / (1024 * 1024)).toFixed(2) + ' MB';
                    previewSize.textContent = sizeStr;

                    const ext = file.name.split('.').pop().toLowerCase();
                    let iconClass = 'fa-file-alt';
                    if(['pdf'].includes(ext)) iconClass = 'fa-file-pdf';
                    else if(['doc', 'docx'].includes(ext)) iconClass = 'fa-file-word';
                    else if(['xls', 'xlsx', 'csv'].includes(ext)) iconClass = 'fa-file-excel';
                    else if(['ppt', 'pptx'].includes(ext)) iconClass = 'fa-file-powerpoint';
                    else if(['zip', 'rar', '7z'].includes(ext)) iconClass = 'fa-file-archive';
                    else if(['jpg', 'jpeg', 'png', 'gif'].includes(ext)) iconClass = 'fa-file-image';
                    else if(['mp4', 'avi', 'mkv'].includes(ext)) iconClass = 'fa-file-video';

                    previewIcon.className = 'fas ' + iconClass;
                    
                    defaultUI.style.display = 'none';
                    previewUI.style.display = 'block';
                    fileInput.style.zIndex = '5'; // push behind remove btn
                } else {
                    defaultUI.style.display = 'block';
                    previewUI.style.display = 'none';
                    fileInput.style.zIndex = '10';
                }
            });

            removeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                fileInput.value = '';
                fileInput.dispatchEvent(new Event('change'));
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/admin/course-files.blade.php ENDPATH**/ ?>