<?php $__env->startSection('title', 'Departments - Admin Dashboard'); ?>
<?php $__env->startSection('page-title', 'Departments'); ?>
<?php $__env->startSection('breadcrumb', 'Departments'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div class="heading-group">
        <h2>Academic Departments</h2>
        <p>Manage main faculties and administrative departments.</p>
    </div>
    <div style="display:flex; gap:8px; margin-right: 15px;">
        <button class="btn btn-primary mt-2 mt-sm-0" data-bs-toggle="modal" data-bs-target="#addDeptModal">
            <i class="fas fa-plus-circle"></i> Add Department
        </button>
    </div>
</div>

<div class="data-card">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5 class="card-title"><i class="fas fa-building-columns"></i> Faculty List</h5>
            <p class="card-subtitle">All active university departments</p>
        </div>
        <form action="<?php echo e(route('admin.departments.index')); ?>" method="GET" class="d-flex flex-wrap align-items-center gap-2" id="searchForm">
            <div class="search-box position-relative">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" id="searchInput" placeholder="Search departments..." value="<?php echo e(request('search')); ?>" style="padding-right: 30px;">
                <?php if(request('search')): ?>
                    <button type="button" class="btn-clear-search" onclick="window.location.href='<?php echo e(route('admin.departments.index')); ?>'" title="Clear Search">
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
                        <th>Department Name</th>
                        <th>Short Code</th>
                        <th>Total Faculty</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="user-cell">
                                <?php
                                    $deptName = trim($dept->name ?? 'Unknown');
                                    $words = preg_split("/\s+/", $deptName);
                                    $initials = count($words) > 1 
                                        ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
                                        : strtoupper(substr($deptName, 0, 2));
                                    $colors = ['emerald', 'cyan', 'rose', 'blue', 'amber', 'purple', 'indigo'];
                                    $colorClass = $colors[strlen($deptName) % count($colors)];
                                ?>
                                <div class="avatar-sm <?php echo e($colorClass); ?>"><?php echo e($initials); ?></div>
                                <div>
                                    <div class="user-name"><?php echo e($dept->name); ?></div>
                                    <div class="user-sub"><?php echo e($dept->faculty ?? 'No Faculty'); ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge dark"><?php echo e($dept->code ?? 'N/A'); ?></span>
                        </td>
                        <td>
                            <span class="badge neutral"><i class="fas fa-users"></i> <?php echo e($dept->teachers_count); ?> Teachers</span>
                        </td>
                        <td>
                            <div class="action-group justify-content-center">
                                <button class="action-btn edit edit-btn" data-bs-toggle="modal" data-bs-target="#editDeptModal"
                                    data-id="<?php echo e($dept->id); ?>"
                                    data-name="<?php echo e($dept->name); ?>"
                                    data-code="<?php echo e($dept->code); ?>"
                                    data-faculty="<?php echo e($dept->faculty); ?>">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="<?php echo e(route('admin.departments.destroy', $dept->id)); ?>" method="POST" class="m-0 p-0 delete-form d-flex align-items-center">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="button" class="action-btn delete delete-btn"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-building-columns fa-3x text-muted mb-3" style="opacity: 0.2;"></i>
                                <h6 class="text-heading fw-bold">No Departments found</h6>
                                <p class="text-muted small">Add your first department to get started.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($departments->hasPages()): ?>
            <div class="px-4 py-3 border-top">
                <?php echo e($departments->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('modals'); ?>
<!-- ADD DEPARTMENT MODAL -->
<div class="modal fade" id="addDeptModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content premium">
            <div class="modal-head gradient">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Add Department</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <form action="<?php echo e(route('admin.departments.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label class="form-label">Department Name</label>
                        <input type="text" name="name" class="form-input" placeholder="e.g. Computer Science" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Short Code</label>
                        <input type="text" name="code" class="form-input" placeholder="e.g. CSE" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Faculty</label>
                        <input type="text" name="faculty" class="form-input" placeholder="e.g. Faculty of Engineering">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" style="margin-top:4px;">
                        <i class="fas fa-check-circle"></i> Save Department
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT DEPARTMENT MODAL -->
<div class="modal fade" id="editDeptModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content premium">
            <div class="modal-head dark-grad">
                <h5 class="modal-title"><i class="fas fa-pen"></i> Edit Department</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <form id="editDeptForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="form-group">
                        <label class="form-label">Department Name</label>
                        <input type="text" name="name" id="edit_name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Short Code</label>
                        <input type="text" name="code" id="edit_code" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Faculty</label>
                        <input type="text" name="faculty" id="edit_faculty" class="form-input">
                    </div>
                    <div class="form-actions mt-3">
                        <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Modal Population
        const editButtons = document.querySelectorAll('.edit-btn');
        const editForm = document.getElementById('editDeptForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                
                document.getElementById('edit_name').value = this.getAttribute('data-name');
                document.getElementById('edit_code').value = this.getAttribute('data-code') || '';
                document.getElementById('edit_faculty').value = this.getAttribute('data-faculty') || '';
                
                let actionUrl = "<?php echo e(route('admin.departments.update', ':id')); ?>";
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
                    text: "You won't be able to revert this!",
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
            Toast.fire({ icon: 'success', title: <?php echo json_encode(session('success')); ?> });
        <?php endif; ?>
        <?php if(session('error')): ?>
            Toast.fire({ icon: 'error', title: <?php echo json_encode(session('error')); ?> });
        <?php endif; ?>
        <?php if($errors->any()): ?>
            Toast.fire({ icon: 'error', title: "Validation Error", text: <?php echo json_encode($errors->first()); ?> });
        <?php endif; ?>
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/admin/departments.blade.php ENDPATH**/ ?>