<?php $__env->startSection('title', 'Categories - Admin Dashboard'); ?>
<?php $__env->startSection('page-title', 'Categories'); ?>
<?php $__env->startSection('breadcrumb', 'Categories'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div class="heading-group">
        <h2>Core Course Categories</h2>
        <p>Manage core course categories and their status.</p>
    </div>
    <div style="display:flex; gap:8px; margin-right: 15px;">
        <button class="btn btn-primary mt-2 mt-sm-0" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="fas fa-plus-circle"></i> Add Category
        </button>
    </div>
</div>

<div class="data-card">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5 class="card-title"><i class="fas fa-tags"></i> Course Categories</h5>
            <p class="card-subtitle">Main academic subject categories</p>
        </div>
        <form action="<?php echo e(route('admin.categories.index')); ?>" method="GET" class="d-flex flex-wrap align-items-center gap-2" id="searchForm">
            <div class="search-box position-relative">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" id="searchInput" placeholder="Search category..." value="<?php echo e(request('search')); ?>" style="padding-right: 30px;">
                <?php if(request('search')): ?>
                    <button type="button" class="btn-clear-search" onclick="window.location.href='<?php echo e(route('admin.categories.index')); ?>'" title="Clear Search">
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
                        <th>Category Name</th>
                        <th>Core Topic</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="icon-cell">
                                <?php
                                    $gradients = [
                                        'linear-gradient(135deg,#3b82f6,#60a5fa)',
                                        'linear-gradient(135deg,#8b5cf6,#a78bfa)',
                                        'linear-gradient(135deg,#f59e0b,#fbbf24)',
                                        'linear-gradient(135deg,#10b981,#34d399)',
                                        'linear-gradient(135deg,#f43f5e,#fb7185)'
                                    ];
                                    $icons = ['fa-code', 'fa-microchip', 'fa-database', 'fa-network-wired', 'fa-laptop-code', 'fa-book'];
                                    $gradient = $gradients[strlen($category->name) % count($gradients)];
                                    $icon = $icons[strlen($category->name) % count($icons)];
                                ?>
                                <div class="icon-wrap" style="background:<?php echo e($gradient); ?>;">
                                    <i class="fas <?php echo e($icon); ?>" style="font-size:0.7rem;"></i>
                                </div>
                                <div class="user-name"><?php echo e($category->name); ?></div>
                            </div>
                        </td>
                        <td>
                            <span style="color:var(--text-secondary);font-size:0.82rem;"><?php echo e($category->description ?? 'No topic description'); ?></span>
                        </td>
                        <td>
                            <?php if($category->is_active): ?>
                                <span class="badge success"><span class="status-indicator active"></span> Active</span>
                            <?php else: ?>
                                <span class="badge danger"><span class="status-indicator inactive" style="background: var(--danger)"></span> Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-group justify-content-center">
                                <button class="action-btn edit edit-btn" data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                                    data-id="<?php echo e($category->id); ?>"
                                    data-name="<?php echo e($category->name); ?>"
                                    data-description="<?php echo e($category->description); ?>"
                                    data-status="<?php echo e($category->is_active ? '1' : '0'); ?>">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="<?php echo e(route('admin.categories.destroy', $category->id)); ?>" method="POST" class="m-0 p-0 delete-form d-flex align-items-center">
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
                                <i class="fas fa-tags fa-3x text-muted mb-3" style="opacity: 0.2;"></i>
                                <h6 class="text-heading fw-bold">No Categories found</h6>
                                <p class="text-muted small">Add your first category to get started.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($categories->hasPages()): ?>
            <div class="px-4 py-3 border-top">
                <?php echo e($categories->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('modals'); ?>
<!-- ADD CATEGORY MODAL -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content premium">
            <div class="modal-head gradient">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Add Category</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <form action="<?php echo e(route('admin.categories.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-input" placeholder="e.g. Networking" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Core Topic Description</label>
                        <input type="text" name="description" class="form-input" placeholder="e.g. TCP/IP, Routing" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="is_active" id="add_status" value="1" checked style="width: 2.5em; height: 1.25em; cursor: pointer;">
                            <label class="form-check-label ms-2" for="add_status" style="cursor: pointer; padding-top: 3px;">Active Category</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" style="margin-top:4px;">
                        <i class="fas fa-check-circle"></i> Add Category
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT CATEGORY MODAL -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content premium">
            <div class="modal-head dark-grad">
                <h5 class="modal-title"><i class="fas fa-pen"></i> Edit Category</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <form id="editCategoryForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="form-group">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="name" id="edit_name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Core Topic Description</label>
                        <input type="text" name="description" id="edit_description" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="is_active" id="edit_status" value="1" style="width: 2.5em; height: 1.25em; cursor: pointer;">
                            <label class="form-check-label ms-2" for="edit_status" style="cursor: pointer; padding-top: 3px;">Active Category</label>
                        </div>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Modal Population
        const editButtons = document.querySelectorAll('.edit-btn');
        const editForm = document.getElementById('editCategoryForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                
                document.getElementById('edit_name').value = this.getAttribute('data-name');
                document.getElementById('edit_description').value = this.getAttribute('data-description') || '';
                
                const status = this.getAttribute('data-status');
                document.getElementById('edit_status').checked = (status === '1');
                
                let actionUrl = "<?php echo e(route('admin.categories.update', ':id')); ?>";
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/admin/categories.blade.php ENDPATH**/ ?>