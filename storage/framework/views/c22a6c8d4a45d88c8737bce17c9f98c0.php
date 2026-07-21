<?php $__env->startSection('title', 'Students - Admin Dashboard'); ?>
<?php $__env->startSection('page-title', 'Student Management'); ?>
<?php $__env->startSection('breadcrumb', 'Student Management'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div class="heading-group">
            <h2>Student Enrollment Records</h2>
            <p>Manage student profiles, course enrollments, and academic data.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
            <i class="fas fa-user-plus"></i> Add Student
        </button>
    </div>

    <!-- Stats Row -->
    <div class="stats-grid grid-3">
        <div class="stat-card">
            <div class="stat-icon-wrap blue"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total Students</div>
                <div class="stat-number"><?php echo e($totalStudents); ?></div>
                <div class="stat-trend up"><i class="fas fa-arrow-up"></i> 12% growth</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrap emerald"><i class="fas fa-user-check"></i></div>
            <div class="stat-info">
                <div class="stat-label">Active Enrolled</div>
                <div class="stat-number"><?php echo e($activeStudents); ?></div>
                <div class="stat-trend neutral"><i class="fas fa-check"></i> 95.6% active</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrap amber"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <div class="stat-label">Pending</div>
                <div class="stat-number"><?php echo e($inactiveStudents); ?></div>
                <div class="stat-trend down"><i class="fas fa-arrow-down"></i> Needs review</div>
            </div>
        </div>
    </div>

    <!-- Student Table -->
    <div class="data-card">
        <div class="card-header">
            <div>
                <h5 class="card-title"><i class="fas fa-user-graduate"></i> Enrolled Students</h5>
                <p class="card-subtitle">All registered students with course assignments</p>
            </div>
            <form action="<?php echo e(route('admin.student-info.index')); ?>" method="GET" class="d-flex align-items-center gap-2" id="searchForm">
                <div class="search-box position-relative">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="search" id="searchInput" placeholder="Search any field..." value="<?php echo e(request('search')); ?>" style="padding-right: 30px;">
                    <?php if(request('search')): ?>
                        <button type="button" class="btn-clear-search" onclick="window.location.href='<?php echo e(route('admin.student-info.index')); ?>'" title="Clear Search">
                            <i class="fas fa-times"></i>
                        </button>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-weight: 500;">Search</button>
            </form>
        </div>
    <div class="card-body">
        <div class="table-wrap">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th>Semester</th>
                        <th>Enrolled Courses</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="user-cell">
                                <?php if($student->profile_image): ?>
                                    <img src="<?php echo e(asset('storage/' . $student->profile_image)); ?>" alt="<?php echo e($student->name); ?>" class="avatar-sm" style="object-fit: cover; border-radius: var(--radius-md); flex-shrink: 0;">
                                <?php else: ?>
                                    <div class="avatar-sm blue d-flex align-items-center justify-content-center text-white fw-bold">
                                        <?php echo e(strtoupper(substr($student->name, 0, 2))); ?>

                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div class="user-name"><?php echo e($student->name); ?></div>
                                    <div class="user-sub"><?php echo e($student->email); ?></div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge dark"><?php echo e($student->student_id); ?></span></td>
                        <td>
                            <?php if($student->semester): ?>
                                <span class="badge neutral"><?php echo e($student->semester); ?></span>
                            <?php else: ?>
                                <span class="text-muted small">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                                $enrolled = json_decode($student->enrolled_courses, true) ?? [];
                                $courseNames = $courses->whereIn('id', $enrolled)->pluck('course_code')->toArray();
                            ?>
                            <?php if(count($courseNames) > 0): ?>
                                <div class="d-flex flex-wrap gap-1">
                                    <?php $__currentLoopData = array_slice($courseNames, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge info"><?php echo e($code); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(count($courseNames) > 3): ?>
                                        <span class="badge neutral" title="<?php echo e(implode(', ', array_slice($courseNames, 3))); ?>">
                                            +<?php echo e(count($courseNames) - 3); ?> more
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <span class="text-muted small">No courses</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($student->is_active): ?>
                                <span class="badge success"><i class="fas fa-check-circle"></i> Active</span>
                            <?php else: ?>
                                <span class="badge danger"><i class="fas fa-times-circle"></i> Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-group">
                                <button class="action-btn edit edit-student-btn" 
                                    data-id="<?php echo e($student->id); ?>"
                                    data-name="<?php echo e($student->name); ?>"
                                    data-email="<?php echo e($student->email); ?>"
                                    data-studentid="<?php echo e($student->student_id); ?>"
                                    data-semester="<?php echo e($student->semester); ?>"
                                    data-isactive="<?php echo e($student->is_active ? 1 : 0); ?>"
                                    data-courses="<?php echo e($student->enrolled_courses); ?>"
                                    data-image="<?php echo e($student->profile_image ? asset('storage/' . $student->profile_image) : ''); ?>">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="<?php echo e(route('admin.student-info.destroy', $student->id)); ?>" method="POST" class="m-0 p-0 delete-form d-flex align-items-center">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="button" class="action-btn delete delete-btn"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-search fa-3x text-muted mb-3" style="opacity: 0.2;"></i>
                                <?php if(request('search')): ?>
                                    <h6 class="text-heading fw-bold">No results found for "<?php echo e(request('search')); ?>"</h6>
                                    <p class="text-muted small">We couldn't find any student matching your search criteria.</p>
                                    <a href="<?php echo e(route('admin.student-info.index')); ?>" class="btn btn-sm btn-primary mt-3">Clear Search</a>
                                <?php else: ?>
                                    <h6 class="text-heading fw-bold">No students found</h6>
                                    <p class="text-muted small">Add your first student to see them listed here.</p>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3 px-3 pb-3">
            <div class="text-muted small">
                Showing <?php echo e($users->firstItem() ?? 0); ?> to <?php echo e($users->lastItem() ?? 0); ?> of <?php echo e($users->total()); ?> students
            </div>
            <div>
                <?php echo e($users->links('pagination::bootstrap-5')); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('modals'); ?>
<div class="modal fade" id="addStudentModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content premium">
                <div class="modal-head gradient"><h5 class="modal-title"><i class="fas fa-user-plus"></i> Register Student</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div>
                <div class="modal-body-content">
                    <form method="POST" action="<?php echo e(route('admin.student-info.store')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-4">
                            <label class="form-label d-block text-muted small mb-2">Profile Image (Optional)</label>
                            <div class="avatar-upload-container">
                                <div class="avatar-preview-box" id="add_upload_zone">
                                    <input type="file" name="profile_image" id="add_profile_image" class="d-none" accept="image/png, image/jpeg, image/gif" onchange="previewAvatar(this, 'add_preview_img', 'add_placeholder', 'add_remove_btn')">
                                    <div id="add_placeholder" onclick="document.getElementById('add_profile_image').click()">
                                        <i class="fas fa-camera"></i>
                                        <span>Upload</span>
                                    </div>
                                    <img id="add_preview_img" src="" alt="Preview" style="display: none;" onclick="document.getElementById('add_profile_image').click()">
                                    <button type="button" id="add_remove_btn" class="avatar-remove-btn" style="display: none;" onclick="removeAvatar('add_profile_image', 'add_preview_img', 'add_placeholder', 'add_remove_btn')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group"><label class="form-label">Student Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-input" placeholder="Enter full name" required></div>
                            <div class="form-group"><label class="form-label">Student ID <span class="text-danger">*</span></label><input type="text" name="student_id" class="form-input" placeholder="e.g. UG02-45-19-021" required></div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group"><label class="form-label">Email Address <span class="text-danger">*</span></label><input type="email" name="email" class="form-input" placeholder="student@example.com" required></div>
                            <div class="form-group"><label class="form-label">Semester / Term <span class="text-danger">*</span></label>
                                <select class="form-select" name="semester" required>
                                    <option value="">Select Semester</option>
                                    <option value="L-1, T-1">L-1, T-1</option>
                                    <option value="L-1, T-2">L-1, T-2</option>
                                    <option value="L-2, T-1">L-2, T-1</option>
                                    <option value="L-2, T-2">L-2, T-2</option>
                                    <option value="L-3, T-1">L-3, T-1</option>
                                    <option value="L-3, T-2">L-3, T-2</option>
                                    <option value="L-4, T-1">L-4, T-1</option>
                                    <option value="L-4, T-2">L-4, T-2</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group"><label class="form-label">Set Password <span class="text-danger">*</span></label><input type="password" name="password" class="form-input" placeholder="Create a secure password" required minlength="8"></div>
                            <div class="form-group">
                                <label class="form-label">Account Status</label>
                                <div class="custom-switch-container">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="is_active" value="1" checked>
                                        <span class="switch-slider"></span>
                                    </label>
                                    <span class="switch-label">Active</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-divider"><i class="fas fa-book-open"></i> Course Enrollment</div>
                        <div class="form-group mb-4">
                            <label class="form-label text-muted small mb-2">Search & Select Courses (Multiple)</label>
                            <select class="form-control choices-multiple" name="courses[]" multiple>
                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($course->id); ?>"><?php echo e($course->course_code); ?> - <?php echo e($course->title ?? 'Course'); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div style="text-align:center; margin-top:20px;">
                            <button type="submit" class="btn btn-primary" style="padding:10px 48px;"><i class="fas fa-check-circle"></i> Add Student</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT STUDENT MODAL -->
    <div class="modal fade" id="editStudentModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content premium">
                <div class="modal-head dark-grad"><h5 class="modal-title"><i class="fas fa-pen"></i> Edit Student</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div>
                <div class="modal-body-content">
                    <form id="editStudentForm" method="POST" action="" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="form-group mb-4">
                            <label class="form-label d-block text-muted small mb-2">Update Profile Image</label>
                            <div class="avatar-upload-container">
                                <div class="avatar-preview-box" id="edit_upload_zone">
                                    <input type="file" name="profile_image" id="edit_profile_image" class="d-none" accept="image/png, image/jpeg, image/gif" onchange="previewAvatar(this, 'edit_preview_img', 'edit_placeholder', 'edit_remove_btn')">
                                    <div id="edit_placeholder" onclick="document.getElementById('edit_profile_image').click()">
                                        <i class="fas fa-camera"></i>
                                        <span>Change</span>
                                    </div>
                                    <img id="edit_preview_img" src="" alt="Preview" style="display: none;" onclick="document.getElementById('edit_profile_image').click()">
                                    <button type="button" id="edit_remove_btn" class="avatar-remove-btn" style="display: none;" onclick="removeEditAvatar()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="remove_image" id="remove_image_hidden" value="0">
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" id="edit_name" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Student ID</label>
                                <input type="text" name="student_id" id="edit_student_id" class="form-input" required>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" id="edit_email" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Semester</label>
                                <select name="semester" id="edit_semester" class="form-select" required>
                                    <option value="L-1, T-1">L-1, T-1</option>
                                    <option value="L-1, T-2">L-1, T-2</option>
                                    <option value="L-2, T-1">L-2, T-1</option>
                                    <option value="L-2, T-2">L-2, T-2</option>
                                    <option value="L-3, T-1">L-3, T-1</option>
                                    <option value="L-3, T-2">L-3, T-2</option>
                                    <option value="L-4, T-1">L-4, T-1</option>
                                    <option value="L-4, T-2">L-4, T-2</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group mt-3">
                                <label class="form-label">Update Password</label>
                                <input type="password" name="password" class="form-input" placeholder="Leave blank to keep current">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Account Status</label>
                                <div class="custom-switch-container">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="is_active" id="edit_is_active" value="1">
                                        <span class="switch-slider"></span>
                                    </label>
                                    <span class="switch-label">Active</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-divider"><i class="fas fa-book-open"></i> Course Subscriptions</div>
                        <div class="form-group mb-4">
                            <label class="form-label text-muted small mb-2">Search & Select Courses (Multiple)</label>
                            <select class="form-control choices-multiple edit-course-select" name="courses[]" id="edit_courses" multiple>
                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($course->id); ?>"><?php echo e($course->course_code); ?> - <?php echo e($course->title ?? 'Course'); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->startPush('scripts'); ?>
<!-- Choices.js CSS & JS for Premium Multi-Select -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<style>
    /* Custom Styling for Choices.js to match Premium Theme */
    .choices[data-type*="select-multiple"] .choices__inner {
        border-radius: 8px;
        border: 1px solid var(--border-light);
        background-color: var(--bg-body);
        padding: 4px 8px;
        min-height: 48px;
    }
    .choices[data-type*="select-multiple"] .choices__button {
        border-left: 1px solid rgba(255,255,255,0.3);
        margin-left: 8px;
    }
    .choices__inner:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .choices__list--multiple .choices__item {
        background-color: var(--primary);
        border: none;
        border-radius: 6px;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
    }
    .choices__list--dropdown {
        border-radius: 8px;
        border: 1px solid var(--border-light);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        background: var(--bg-card);
        color: var(--text-regular);
        z-index: 1060; /* Above bootstrap modal */
    }
    .choices__list--dropdown .choices__item--selectable.is-highlighted {
        background-color: rgba(59, 130, 246, 0.1);
        color: var(--primary);
    }
    .avatar-upload-container {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
    }
    .btn-clear-search {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        padding: 0;
        font-size: 1rem;
        transition: color 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-clear-search:hover {
        color: #ef4444;
    }
    .avatar-preview-box {
        position: relative;
        width: 110px;
        height: 110px;
        border-radius: 50%;
        border: 3px dashed var(--border-light);
        background: rgba(255, 255, 255, 0.03);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        cursor: pointer;
    }
    .avatar-preview-box:hover {
        border-color: var(--primary);
        background: rgba(59, 130, 246, 0.05);
    }
    .avatar-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        z-index: 2;
    }
    .avatar-preview-box div {
        text-align: center;
        color: var(--text-muted);
        z-index: 1;
        position: absolute;
    }
    .avatar-preview-box div i {
        font-size: 1.5rem;
        display: block;
        margin-bottom: 5px;
    }
    .avatar-preview-box div span {
        font-size: 0.75rem;
        font-weight: 600;
    }
    .avatar-remove-btn {
        position: absolute;
        top: 0;
        right: -5px;
        background: #ef4444;
        color: white;
        border: 2px solid var(--bg-card);
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 3;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        transition: all 0.2s;
    }
    .avatar-remove-btn:hover {
        background: #dc2626;
        transform: scale(1.1);
    }
    /* Switch styles */
    .custom-switch-container { display: flex; align-items: center; gap: 10px; }
    .custom-switch { position: relative; display: inline-block; width: 48px; height: 24px; }
    .custom-switch input { opacity: 0; width: 0; height: 0; }
    .switch-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 24px; }
    .switch-slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
    input:checked + .switch-slider { background-color: var(--primary); }
    input:checked + .switch-slider:before { transform: translateX(24px); }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Choices.js
        const choiceElements = document.querySelectorAll('.choices-multiple');
        const choiceInstances = {};
        
        choiceElements.forEach((el, index) => {
            choiceInstances[el.id || 'choice_' + index] = new Choices(el, {
                removeItemButton: true,
                searchPlaceholderValue: 'Search for courses...',
                placeholderValue: 'Select courses',
                itemSelectText: '',
                shouldSort: false
            });
        });

        // Edit Modal Population
        const editButtons = document.querySelectorAll('.edit-student-btn');
        const editForm = document.getElementById('editStudentForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const imagePath = this.getAttribute('data-image');
                
                document.getElementById('edit_name').value = this.getAttribute('data-name');
                document.getElementById('edit_email').value = this.getAttribute('data-email');
                document.getElementById('edit_student_id').value = this.getAttribute('data-studentid');
                document.getElementById('edit_semester').value = this.getAttribute('data-semester');
                document.getElementById('edit_is_active').checked = this.getAttribute('data-isactive') === '1';
                
                // Image Handling
                const previewImg = document.getElementById('edit_preview_img');
                const placeholder = document.getElementById('edit_placeholder');
                const removeBtn = document.getElementById('edit_remove_btn');
                
                document.getElementById('remove_image_hidden').value = "0";
                document.getElementById('edit_profile_image').value = '';

                if(imagePath) {
                    previewImg.src = imagePath;
                    previewImg.style.display = 'block';
                    placeholder.style.display = 'none';
                    removeBtn.style.display = 'flex';
                } else {
                    previewImg.src = '';
                    previewImg.style.display = 'none';
                    placeholder.style.display = 'block';
                    removeBtn.style.display = 'none';
                }
                
                // Set enrolled courses using Choices.js API
                const courses = JSON.parse(this.getAttribute('data-courses') || '[]');
                
                // Clear existing selections
                const editSelectId = 'edit_courses';
                if(choiceInstances[editSelectId]) {
                    choiceInstances[editSelectId].removeActiveItems();
                    
                    // Set new selections
                    if(courses && courses.length > 0) {
                        choiceInstances[editSelectId].setChoiceByValue(courses.map(String));
                    }
                }
                
                // Set form action
                let actionUrl = "<?php echo e(route('admin.student-info.update', ':id')); ?>";
                editForm.action = actionUrl.replace(':id', id);
                
                // Show modal
                new bootstrap.Modal(document.getElementById('editStudentModal')).show();
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
                    text: "This student and all their data will be removed!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Yes, delete!'
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
            Toast.fire({
                icon: 'error',
                title: "Validation Error",
                text: "<?php echo e($errors->first()); ?>"
            });
        <?php endif; ?>
    });

    // Professional Image Preview Helper
    // Avatar Preview Helper
    function previewAvatar(input, previewId, placeholderId, removeBtnId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
                document.getElementById(previewId).style.display = 'block';
                document.getElementById(placeholderId).style.display = 'none';
                document.getElementById(removeBtnId).style.display = 'flex';
                if(previewId === 'edit_preview_img') {
                    document.getElementById('remove_image_hidden').value = "0";
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeAvatar(inputId, previewId, placeholderId, removeBtnId) {
        document.getElementById(inputId).value = '';
        document.getElementById(previewId).src = '';
        document.getElementById(previewId).style.display = 'none';
        document.getElementById(placeholderId).style.display = 'block';
        document.getElementById(removeBtnId).style.display = 'none';
    }

    function removeEditAvatar() {
        document.getElementById('edit_profile_image').value = '';
        document.getElementById('edit_preview_img').src = '';
        document.getElementById('edit_preview_img').style.display = 'none';
        document.getElementById('edit_placeholder').style.display = 'block';
        document.getElementById('edit_remove_btn').style.display = 'none';
        document.getElementById('remove_image_hidden').value = "1";
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/admin/students.blade.php ENDPATH**/ ?>