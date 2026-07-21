<?php $__env->startSection('title', 'Courses - Admin Dashboard'); ?>
<?php $__env->startSection('page-title', 'Course Information'); ?>
<?php $__env->startSection('breadcrumb', 'Course Information'); ?>

<?php $__env->startPush('styles'); ?>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
    /* Custom premium styling for Tom Select */
    .ts-control {
        border: 1px solid var(--border-color) !important;
        border-radius: var(--radius-md) !important;
        background-color: var(--bg-surface) !important;
        color: var(--text-primary) !important;
        padding: 8px 14px !important;
        min-height: 42px !important;
        box-shadow: none !important;
    }
    .ts-dropdown {
        border: 1px solid var(--border-color) !important;
        border-radius: var(--radius-md) !important;
        background-color: var(--bg-surface) !important;
        box-shadow: var(--shadow-md) !important;
        color: var(--text-primary) !important;
        z-index: 9999 !important;
    }
    .ts-dropdown .option:hover, .ts-dropdown .active {
        background-color: var(--primary-color) !important;
        color: white !important;
    }
    .ts-control > input {
        color: var(--text-primary) !important;
    }
    .ts-dropdown .dropdown-input-wrap {
        padding: 8px !important;
    }
    .ts-dropdown .dropdown-input {
        border: 1px solid var(--border-color) !important;
        border-radius: var(--radius-sm) !important;
        background-color: var(--bg-card) !important;
        color: var(--text-primary) !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="heading-group"><h2>Course Registry</h2><p>Manage courses, codes, and department allocations.</p></div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal"><i class="fas fa-plus-circle"></i> Add Course</button>
</div>

<div class="data-card">
    <div class="card-header">
        <div><h5 class="card-title"><i class="fas fa-book-open"></i> Available Courses</h5><p class="card-subtitle">All registered courses with department info</p></div>
        <form action="<?php echo e(route('admin.courses.index')); ?>" method="GET" class="d-flex align-items-center gap-2" id="searchForm">
            <div class="search-box position-relative">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" id="searchInput" placeholder="Search by title, subtitle, dept or status..." value="<?php echo e(request('search')); ?>" style="padding-right: 30px;">
                <?php if(request('search')): ?>
                    <button type="button" class="btn-clear-search" onclick="window.location.href='<?php echo e(route('admin.courses.index')); ?>'" title="Clear Search">
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
                <thead><tr><th>Course Code</th><th>Course Title</th><th>Department</th><th>Status</th><th class="text-center">Action</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><span class="badge dark"><i class="fas fa-hashtag"></i> <?php echo e($course->course_code); ?></span></td>
                        <td>
                            <div class="user-name"><?php echo e($course->title); ?></div>
                            <div class="user-sub"><?php echo e($course->subtitle ?? 'N/A'); ?></div>
                        </td>
                        <td>
                            <?php $deptColors = ['primary', 'cyan', 'rose', 'emerald', 'amber', 'purple', 'indigo']; ?>
                            <span class="badge <?php echo e($deptColors[strlen($course->department->name ?? 'A') % count($deptColors)]); ?>">
                                <i class="fas fa-building-columns"></i> <?php echo e($course->department->name ?? 'N/A'); ?>

                            </span>
                        </td>
                        <td>
                            <?php if($course->is_active): ?>
                                <span class="badge success"><i class="fas fa-check-circle"></i> Active</span>
                            <?php else: ?>
                                <span class="badge danger"><i class="fas fa-times-circle"></i> Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-group">
                                <button class="action-btn edit edit-course-btn" data-bs-toggle="modal" data-bs-target="#editCourseModal"
                                    data-id="<?php echo e($course->id); ?>"
                                    data-code="<?php echo e($course->course_code); ?>"
                                    data-title="<?php echo e($course->title); ?>"
                                    data-subtitle="<?php echo e($course->subtitle); ?>"
                                    data-status="<?php echo e($course->is_active ? '1' : '0'); ?>"
                                    data-department="<?php echo e($course->department_id); ?>">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="<?php echo e(route('admin.courses.destroy', $course->id)); ?>" method="POST" class="m-0 p-0 delete-form d-flex align-items-center">
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
                                    <p class="text-muted small">We couldn't find any course matching your criteria.</p>
                                    <a href="<?php echo e(route('admin.courses.index')); ?>" class="btn btn-sm btn-primary mt-3">Clear Search</a>
                                <?php else: ?>
                                    <h6 class="text-heading fw-bold">No courses found</h6>
                                    <p class="text-muted small">Add your first course to get started.</p>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($courses->hasPages()): ?>
            <div class="px-4 py-3 border-top">
                <?php echo e($courses->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('modals'); ?>
<div class="modal fade" id="addCourseModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content premium"><div class="modal-head gradient"><h5 class="modal-title"><i class="fas fa-plus-circle"></i> Register Course</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content">
    <form action="<?php echo e(route('admin.courses.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group"><label class="form-label">Course Code <span class="text-danger">*</span></label><input type="text" name="course_code" class="form-input" placeholder="e.g. CSE-201" required></div>
        <div class="form-group"><label class="form-label">Course Title <span class="text-danger">*</span></label><input type="text" name="title" class="form-input" placeholder="e.g. Object Oriented Programming" required></div>
        <div class="form-group"><label class="form-label">Course Subtitle</label><input type="text" name="subtitle" class="form-input" placeholder="e.g. Theory + Lab"></div>
        <div class="form-group"><label class="form-label">Status <span class="text-danger">*</span></label>
            <select name="is_active" class="form-select" required>
                <option value="1" selected>Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
        <div class="form-group"><label class="form-label">Department</label>
            <select name="department_id" id="add_department" class="searchable-select" placeholder="Choose Department">
                <option value="">Choose Department</option>
                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dept->id); ?>"><?php echo e($dept->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-block" style="margin-top:4px;"><i class="fas fa-check-circle"></i> Add Course</button>
    </form>
</div></div></div></div>

<!-- EDIT COURSE -->
<div class="modal fade" id="editCourseModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content premium"><div class="modal-head dark-grad"><h5 class="modal-title"><i class="fas fa-pen"></i> Edit Course</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content">
    <form id="editCourseForm" action="" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="form-group"><label class="form-label">Course Code <span class="text-danger">*</span></label><input type="text" name="course_code" id="edit_code" class="form-input" required></div>
        <div class="form-group"><label class="form-label">Course Title <span class="text-danger">*</span></label><input type="text" name="title" id="edit_title" class="form-input" required></div>
        <div class="form-group"><label class="form-label">Course Subtitle</label><input type="text" name="subtitle" id="edit_subtitle" class="form-input"></div>
        <div class="form-group"><label class="form-label">Status <span class="text-danger">*</span></label>
            <select name="is_active" id="edit_status" class="form-select" required>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
        <div class="form-group"><label class="form-label">Department</label>
            <select name="department_id" id="edit_department" class="searchable-select" placeholder="Choose Department">
                <option value="">Choose Department</option>
                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dept->id); ?>"><?php echo e($dept->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-actions"><button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Update</button></div>
    </form>
</div></div></div></div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize TomSelect with dropdown_input plugin
        let addDeptSelect = new TomSelect('#add_department', {
            create: false,
            plugins: ['dropdown_input'],
            sortField: { field: "text", direction: "asc" }
        });
        
        let editDeptSelect = new TomSelect('#edit_department', {
            create: false,
            plugins: ['dropdown_input'],
            sortField: { field: "text", direction: "asc" }
        });

        // Edit Modal Population
        const editButtons = document.querySelectorAll('.edit-course-btn');
        const editForm = document.getElementById('editCourseForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('edit_code').value = this.getAttribute('data-code');
                document.getElementById('edit_title').value = this.getAttribute('data-title');
                document.getElementById('edit_subtitle').value = this.getAttribute('data-subtitle');
                document.getElementById('edit_status').value = this.getAttribute('data-status');
                
                // Update TomSelect value
                editDeptSelect.setValue(this.getAttribute('data-department'));
                
                let actionUrl = "<?php echo e(route('admin.courses.update', ':id')); ?>";
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
                    text: "This course will be permanently deleted!",
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
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/admin/courses.blade.php ENDPATH**/ ?>