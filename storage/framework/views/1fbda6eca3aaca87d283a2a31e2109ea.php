<?php $__env->startSection('title', 'Teachers - Admin Dashboard'); ?>
<?php $__env->startSection('page-title', 'Teacher Management'); ?>
<?php $__env->startSection('breadcrumb', 'Teacher Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="heading-group"><h2>Faculty Members</h2><p>Manage teachers, departments, and course assignments.</p></div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeacherModal"><i class="fas fa-user-plus"></i> Add Teacher</button>
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
            <thead><tr><th>Teacher Name</th><th class="text-center">Email</th><th class="text-center">Department</th><th class="text-center">Status</th><th class="text-center">Offered Courses</th><th class="text-center">Action</th></tr></thead>
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
                    <td class="text-center"><span style="color:var(--text-secondary); font-size:0.82rem;"><?php echo e($teacher->email); ?></span></td>
                    <td class="text-center">
                        <?php if($teacher->department): ?>
                            <span class="badge primary"><i class="fas fa-building-columns"></i> <?php echo e($teacher->department->name); ?></span>
                        <?php else: ?>
                            <span class="badge neutral"><i class="fas fa-building-columns"></i> Not Assigned</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if($teacher->is_active): ?>
                            <span class="badge success"><i class="fas fa-check-circle"></i> Active</span>
                        <?php else: ?>
                            <span class="badge danger"><i class="fas fa-times-circle"></i> Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php $__empty_2 = true; $__currentLoopData = $teacher->courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <span class="badge success"><?php echo e($course->course_code); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <span class="text-muted" style="font-size: 0.8rem;">No courses assigned</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="action-group justify-content-center">
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
            <div class="form-group"><label class="form-label">Department</label><select name="department_id" id="add_department_id" class="form-select" placeholder="Select Department"><option value="">Select Department</option><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($dept->id); ?>"><?php echo e($dept->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
            <div class="form-group"><label class="form-label">Designation</label><input type="text" name="designation" class="form-input" placeholder="e.g. Senior Lecturer"></div>
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Set Password <span class="text-danger">*</span></label>
                <div style="position: relative;">
                    <input type="password" name="password" class="form-input" placeholder="Create secure password" required minlength="8" style="padding-right: 40px;">
                    <i class="fas fa-eye toggle-pwd" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-muted);"></i>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Account Status</label>
                <div class="custom-switch-container" style="margin-top: 8px;">
                    <label class="custom-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span class="switch-slider"></span>
                    </label>
                    <span class="switch-label text-muted small fw-bold">Active</span>
                </div>
            </div>
        </div>
        <div class="form-divider"><i class="fas fa-book-open"></i> Offer Courses</div>
        <div class="form-group mb-4 px-3">
            <label class="form-label text-muted small mb-2">Search & Select Courses (Multiple)</label>
            <select class="form-select" id="add_courses" name="courses[]" multiple placeholder="Select courses">
                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($course->id); ?>"><?php echo e($course->course_code); ?> - <?php echo e($course->title ?? 'Course'); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div style="display:flex; justify-content:center; gap:12px; margin-top:24px;">
            <button type="button" class="btn btn-light" style="padding:10px 32px; font-weight:600; border: 1px solid #cbd5e1; background-color: #f1f5f9; color: #334155; box-shadow: 0 2px 4px rgba(0,0,0,0.05);" data-bs-dismiss="modal" onmouseover="this.style.backgroundColor='#e2e8f0'" onmouseout="this.style.backgroundColor='#f1f5f9'"><i class="fas fa-times"></i> Cancel</button>
            <button type="submit" class="btn btn-primary" style="padding:10px 48px;"><i class="fas fa-check-circle"></i> Register</button>
        </div>
    </form></div></div></div></div>

    <!-- EDIT TEACHER MODAL -->
    <div class="modal fade" id="editTeacherModal" tabindex="-1"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content premium"><div class="modal-head dark-grad"><h5 class="modal-title"><i class="fas fa-pen"></i> Edit Teacher</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form id="editTeacherForm" action="" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="form-grid"><div class="form-group"><label class="form-label">Full Name</label><input type="text" name="name" id="edit_name" class="form-input" required></div><div class="form-group"><label class="form-label">Email</label><input type="email" name="email" id="edit_email" class="form-input" required></div></div>
        <div class="form-grid">
            <div class="form-group"><label class="form-label">Department</label><select name="department_id" id="edit_department_id" class="form-select" placeholder="Select Department"><option value="">Select Department</option><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($dept->id); ?>"><?php echo e($dept->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
            <div class="form-group"><label class="form-label">Designation</label><input type="text" name="designation" id="edit_designation" class="form-input" placeholder="e.g. Professor"></div>
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">New Password</label>
                <div style="position: relative;">
                    <input type="password" name="password" class="form-input" placeholder="Leave blank if no change" minlength="8" style="padding-right: 40px;">
                    <i class="fas fa-eye toggle-pwd" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-muted);"></i>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Account Status</label>
                <div class="custom-switch-container" style="margin-top: 8px;">
                    <label class="custom-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="edit_is_active" value="1">
                        <span class="switch-slider"></span>
                    </label>
                    <span class="switch-label text-muted small fw-bold">Active</span>
                </div>
            </div>
        </div>
        <div class="form-divider"><i class="fas fa-book-open"></i> Offer Courses</div>
        <div class="form-group mb-4 px-3">
            <label class="form-label text-muted small mb-2">Search & Select Courses (Multiple)</label>
            <select class="form-select edit-course-select" id="edit_courses" name="courses[]" multiple placeholder="Select courses">
                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($course->id); ?>"><?php echo e($course->course_code); ?> - <?php echo e($course->title ?? 'Course'); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-actions"><button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Update</button></div>
    </form></div></div></div></div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<style>
    /* Clean TomSelect styling for Department */
    .ts-wrapper.ts-department {
        padding: 0 !important;
        border: none !important;
        background-color: transparent !important;
        box-shadow: none !important;
    }
    .ts-wrapper.ts-department .ts-control {
        border: 1.5px solid var(--border) !important;
        border-radius: var(--radius-md) !important;
        background-color: var(--bg-input) !important;
        color: var(--text-body) !important;
        font-size: 0.85rem !important;
        padding: 9px 30px 9px 13px !important; /* Right padding for arrow */
        min-height: 42px !important;
        box-shadow: none !important;
        display: flex;
        align-items: center;
        transition: all var(--duration-base) var(--ease);
        cursor: pointer;
    }
    .ts-wrapper.ts-department.focus .ts-control {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px var(--primary-glow) !important;
        background-color: white !important;
    }
    /* Fix Placeholder */
    .ts-wrapper.ts-department .ts-control .item[data-value=""] {
        color: var(--text-muted) !important;
    }
    
    /* TomSelect styling for Course (Multiple) */
    .ts-wrapper.ts-course {
        padding: 0 !important;
        border: none !important;
        background-color: transparent !important;
        box-shadow: none !important;
    }
    .ts-wrapper.ts-course .ts-control {
        border: 1.5px solid var(--border) !important;
        border-radius: var(--radius-md) !important;
        background-color: var(--bg-input) !important;
        color: var(--text-body) !important;
        font-size: 0.85rem !important;
        padding: 9px 30px 9px 13px !important; /* Right padding for arrow */
        min-height: 48px !important;
        box-shadow: none !important;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 6px;
        transition: all var(--duration-base) var(--ease);
        cursor: pointer;
    }
    .ts-wrapper.ts-course.focus .ts-control {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px var(--primary-glow) !important;
        background-color: white !important;
    }

    /* CLEAR, LARGE DROPDOWN ARROW INDICATOR */
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
    .ts-dropdown {
        border: 1px solid var(--border) !important;
        border-radius: var(--radius-md) !important;
        background-color: white !important;
        box-shadow: var(--shadow-md) !important;
        z-index: 9999 !important;
    }
    .ts-dropdown .ts-dropdown-content {
        max-height: 250px !important;
        overflow-y: auto !important;
        padding-bottom: 5px;
    }
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
    }

    /* Switch styles */
    .custom-switch-container { display: flex; align-items: center; gap: 10px; }
    .custom-switch { position: relative; display: inline-block; width: 48px; height: 24px; }
    .custom-switch input { opacity: 0; width: 0; height: 0; }
    .switch-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .4s; border-radius: 24px; }
    .switch-slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
    input:checked + .switch-slider { background-color: var(--primary); }
    input:checked + .switch-slider:before { transform: translateX(24px); }
</style>
<!-- Choices.js CSS & JS for Premium Multi-Select -->
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

        // Initialize TomSelect for Courses (Multiple)
        if(document.getElementById('add_courses')) {
            window.addCourseSelect = new TomSelect("#add_courses", {
                plugins: ['remove_button'],
                create: false,
                maxOptions: null,
                wrapperClass: 'ts-wrapper form-select ts-course',
                sortField: { field: "text", direction: "asc" }
            });
        }
        
        if(document.getElementById('edit_courses')) {
            window.editCourseSelect = new TomSelect("#edit_courses", {
                plugins: ['remove_button'],
                create: false,
                maxOptions: null,
                wrapperClass: 'ts-wrapper form-select ts-course',
                sortField: { field: "text", direction: "asc" }
            });
        }

        // Initialize TomSelect for Department
        if(document.getElementById('add_department_id')) {
            let addDept = new TomSelect("#add_department_id", {
                create: false,
                controlInput: null,
                maxOptions: null,
                allowEmptyOption: true,
                wrapperClass: 'ts-wrapper form-select ts-department',
                plugins: ['dropdown_input'],
                sortField: { field: "text", direction: "asc" }
            });
            let searchInput = addDept.dropdown.querySelector('input');
            if(searchInput) searchInput.setAttribute('placeholder', 'Search department...');
        }
        
        if(document.getElementById('edit_department_id')) {
            window.editDeptSelect = new TomSelect("#edit_department_id", {
                create: false,
                controlInput: null,
                maxOptions: null,
                allowEmptyOption: true,
                wrapperClass: 'ts-wrapper form-select ts-department',
                plugins: ['dropdown_input'],
                sortField: { field: "text", direction: "asc" }
            });
            let searchInput = window.editDeptSelect.dropdown.querySelector('input');
            if(searchInput) searchInput.setAttribute('placeholder', 'Search department...');
        }

        // Edit Modal Population
        const editButtons = document.querySelectorAll('.edit-teacher-btn');
        const editForm = document.getElementById('editTeacherForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('edit_name').value = this.getAttribute('data-name');
                document.getElementById('edit_email').value = this.getAttribute('data-email');
                const deptId = this.getAttribute('data-department');
                if (window.editDeptSelect) {
                    window.editDeptSelect.setValue(deptId);
                } else {
                    document.getElementById('edit_department_id').value = deptId;
                }
                document.getElementById('edit_designation').value = this.getAttribute('data-designation');
                document.getElementById('edit_is_active').checked = this.getAttribute('data-active') === '1';
                
                // Set courses using TomSelect API
                const courseStr = this.getAttribute('data-courses');
                let courses = [];
                try { courses = JSON.parse(courseStr); } catch(e){}
                
                if (window.editCourseSelect) {
                    window.editCourseSelect.clear();
                    if(courses.length > 0) {
                        window.editCourseSelect.setValue(courses.map(c => c.toString()));
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views\admin\teachers.blade.php ENDPATH**/ ?>