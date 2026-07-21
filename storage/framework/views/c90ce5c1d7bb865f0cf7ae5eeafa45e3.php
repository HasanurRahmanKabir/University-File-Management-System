<?php $__env->startSection('title', 'Teachers - Admin Dashboard'); ?>
<?php $__env->startSection('page-title', 'Teacher Management'); ?>
<?php $__env->startSection('breadcrumb', 'Teacher Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="heading-group"><h2>Faculty Members</h2><p>Manage teachers, departments, and course assignments.</p></div>
    <div style="display:flex; gap:8px; margin-right: 15px;">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeacherModal"><i class="fas fa-user-plus"></i> Add Teacher</button>
    </div>
</div>

<div class="data-card">
    <div class="card-header">
        <div><h5 class="card-title"><i class="fas fa-chalkboard-teacher"></i> Faculty List</h5><p class="card-subtitle">All registered teachers with department info</p></div>
        <form action="<?php echo e(route('admin.teacher-info.index')); ?>" method="GET" class="d-flex align-items-center gap-2" id="searchForm">
            <div class="search-box position-relative">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" id="searchInput" placeholder="Search any field..." value="<?php echo e(request('search')); ?>" style="padding-right: 30px;">
                <?php if(request('search')): ?>
                    <button type="button" class="btn-clear-search" onclick="window.location.href='<?php echo e(route('admin.teacher-info.index')); ?>'" title="Clear Search">
                        <i class="fas fa-times"></i>
                    </button>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-weight: 500;">Search</button>
        </form>
    </div>
    <div class="card-body"><div class="table-wrap">
        <table class="premium-table">
            <thead><tr><th>Teacher Name</th><th>Email</th><th>Department</th><th>Status</th><th>Offered Courses</th><th class="text-center">Action</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="user-cell">
                            <div class="avatar-sm purple"><?php echo e(strtoupper(substr($teacher->name, 0, 2))); ?></div>
                            <div>
                                <div class="user-name"><?php echo e($teacher->name); ?></div>
                                <div class="user-sub"><?php echo e($teacher->designation ?? 'Faculty Member'); ?></div>
                            </div>
                        </div>
                    </td>
                    <td><span style="color:var(--text-secondary); font-size:0.82rem;"><?php echo e($teacher->email); ?></span></td>
                    <td>
                        <?php if($teacher->department): ?>
                            <span class="badge primary"><i class="fas fa-building-columns"></i> <?php echo e($teacher->department->name); ?></span>
                        <?php else: ?>
                            <span class="badge neutral"><i class="fas fa-building-columns"></i> Not Assigned</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($teacher->is_active): ?>
                            <span class="badge success"><i class="fas fa-check-circle"></i> Active</span>
                        <?php else: ?>
                            <span class="badge danger"><i class="fas fa-times-circle"></i> Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php $__empty_2 = true; $__currentLoopData = $teacher->courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <span class="badge success"><?php echo e($course->course_code); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <span class="text-muted" style="font-size: 0.8rem;">No courses assigned</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="action-group">
                            <button class="action-btn edit edit-teacher-btn" data-bs-toggle="modal" data-bs-target="#editTeacherModal"
                                data-id="<?php echo e($teacher->id); ?>"
                                data-name="<?php echo e($teacher->name); ?>"
                                data-email="<?php echo e($teacher->email); ?>"
                                data-department="<?php echo e($teacher->department_id); ?>"
                                data-designation="<?php echo e($teacher->designation); ?>"
                                data-active="<?php echo e($teacher->is_active ? 1 : 0); ?>"
                                data-courses="<?php echo e(json_encode($teacher->courses->pluck('id')->toArray())); ?>">
                                <i class="fas fa-pen"></i>
                            </button>
                            <form action="<?php echo e(route('admin.teacher-info.destroy', $teacher->id)); ?>" method="POST" class="m-0 p-0 delete-form d-flex align-items-center">
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
                            <i class="fas fa-search fa-3x text-muted mb-3" style="opacity: 0.2;"></i>
                            <?php if(request('search')): ?>
                                <h6 class="text-heading fw-bold">No results found for "<?php echo e(request('search')); ?>"</h6>
                                <p class="text-muted small">We couldn't find any teacher matching your search criteria.</p>
                                <a href="<?php echo e(route('admin.teacher-info.index')); ?>" class="btn btn-sm btn-primary mt-3">Clear Search</a>
                            <?php else: ?>
                                <h6 class="text-heading fw-bold">No teachers found</h6>
                                <p class="text-muted small">Add your first teacher to see them listed here.</p>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($users->hasPages()): ?>
        <div class="px-4 py-3 border-top">
            <?php echo e($users->links()); ?>

        </div>
    <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('modals'); ?>
    <!-- ADD TEACHER -->
    <div class="modal fade" id="addTeacherModal" tabindex="-1"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content premium"><div class="modal-head gradient"><h5 class="modal-title"><i class="fas fa-user-plus"></i> Register Teacher</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form action="<?php echo e(route('admin.teacher-info.store')); ?>" method="POST"><?php echo csrf_field(); ?>
        <div class="form-grid"><div class="form-group"><label class="form-label">Full Name</label><input type="text" name="name" class="form-input" placeholder="Enter full name" required></div><div class="form-group"><label class="form-label">Email Address</label><input type="email" name="email" class="form-input" placeholder="example@univ.edu" required></div></div>
        <div class="form-grid">
            <div class="form-group"><label class="form-label">Department</label><select name="department_id" class="form-select"><option selected disabled>Select Department</option><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($dept->id); ?>"><?php echo e($dept->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
            <div class="form-group"><label class="form-label">Designation</label><input type="text" name="designation" class="form-input" placeholder="e.g. Senior Lecturer"></div>
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Set Password</label>
                <div style="position: relative;">
                    <input type="password" name="password" class="form-input" placeholder="Create password" required style="padding-right: 40px;">
                    <i class="fas fa-eye toggle-pwd" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-muted);"></i>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Account Status</label>
                <select name="is_active" class="form-select" required>
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
        <div class="form-divider"><i class="fas fa-book-open"></i> Offer Courses</div>
        <div class="form-group mb-4 px-3">
            <label class="form-label text-muted small mb-2">Search & Select Courses (Multiple)</label>
            <select class="form-control choices-multiple" name="courses[]" multiple>
                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($course->id); ?>"><?php echo e($course->course_code); ?> - <?php echo e($course->title ?? 'Course'); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div style="text-align:center;margin-top:20px;"><button type="submit" class="btn btn-primary" style="padding:10px 48px;"><i class="fas fa-check-circle"></i> Register</button></div>
    </form></div></div></div></div>

    <!-- EDIT TEACHER MODAL -->
    <div class="modal fade" id="editTeacherModal" tabindex="-1"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content premium"><div class="modal-head dark-grad"><h5 class="modal-title"><i class="fas fa-pen"></i> Edit Teacher</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form id="editTeacherForm" action="" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="form-grid"><div class="form-group"><label class="form-label">Full Name</label><input type="text" name="name" id="edit_name" class="form-input" required></div><div class="form-group"><label class="form-label">Email</label><input type="email" name="email" id="edit_email" class="form-input" required></div></div>
        <div class="form-grid">
            <div class="form-group"><label class="form-label">Department</label><select name="department_id" id="edit_department_id" class="form-select"><option value="">Select Department</option><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($dept->id); ?>"><?php echo e($dept->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
            <div class="form-group"><label class="form-label">Designation</label><input type="text" name="designation" id="edit_designation" class="form-input" placeholder="e.g. Professor"></div>
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">New Password</label>
                <div style="position: relative;">
                    <input type="password" name="password" class="form-input" placeholder="Leave blank if no change" style="padding-right: 40px;">
                    <i class="fas fa-eye toggle-pwd" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-muted);"></i>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Account Status</label>
                <select name="is_active" id="edit_is_active" class="form-select" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
        <div class="form-divider"><i class="fas fa-book-open"></i> Offer Courses</div>
        <div class="form-group mb-4 px-3">
            <label class="form-label text-muted small mb-2">Search & Select Courses (Multiple)</label>
            <select class="form-control choices-multiple edit-course-select" id="edit_courses" name="courses[]" multiple>
                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($course->id); ?>"><?php echo e($course->course_code); ?> - <?php echo e($course->title ?? 'Course'); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-actions"><button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Update</button></div>
    </form></div></div></div></div>
<?php $__env->stopPush(); ?>

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
    /* Hide the dropdown entirely if there are absolutely no courses to choose from */
    .choices__list--dropdown:has(.has-no-choices) {
        display: none !important;
        opacity: 0 !important;
        pointer-events: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password Visibility Toggle
        const togglePwds = document.querySelectorAll('.toggle-pwd');
        togglePwds.forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });
        });

        // Initialize Choices.js for course selection
        const choiceElements = document.querySelectorAll('.choices-multiple');
        const choiceInstances = {};
        
        choiceElements.forEach((el, index) => {
            choiceInstances[el.id || 'choice_' + index] = new Choices(el, {
                removeItemButton: true,
                searchPlaceholderValue: 'Search for courses...',
                placeholderValue: 'Select courses',
                itemSelectText: '',
                noChoicesText: 'No courses available',
                noResultsText: 'No matching courses found',
                shouldSort: false
            });
        });

        // Edit Modal Population
        const editButtons = document.querySelectorAll('.edit-teacher-btn');
        const editForm = document.getElementById('editTeacherForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('edit_name').value = this.getAttribute('data-name');
                document.getElementById('edit_email').value = this.getAttribute('data-email');
                document.getElementById('edit_department_id').value = this.getAttribute('data-department');
                document.getElementById('edit_designation').value = this.getAttribute('data-designation');
                document.getElementById('edit_is_active').value = this.getAttribute('data-active');
                
                // Set courses using Choices.js API
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
                let actionUrl = "<?php echo e(route('admin.teacher-info.update', ':id')); ?>";
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
                    text: "This teacher and all their data will be removed!",
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
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/admin/teachers.blade.php ENDPATH**/ ?>