<?php $__env->startSection('title', 'Subcategories - Admin Dashboard'); ?>
<?php $__env->startSection('page-title', 'Subcategories'); ?>
<?php $__env->startSection('breadcrumb', 'Subcategories'); ?>

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
        box-shadow: var(--shadow-sm) !important;
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
    .ts-wrapper.ts-category:not(.has-items) .ts-control::before {
        content: "Select Category...";
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
        background-color: white !important;
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
        <h2>Subcategory Management</h2>
        <p>Manage minor, allied, and non-technical subcategories.</p>
    </div>
    <div style="display:flex; gap:8px; margin-right: 15px;">
        <button class="btn btn-primary mt-2 mt-sm-0" data-bs-toggle="modal" data-bs-target="#addSubCategoryModal">
            <i class="fas fa-plus-circle"></i> Add Subcategory
        </button>
    </div>
</div>

<div class="data-card">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5 class="card-title"><i class="fas fa-layer-group"></i> Minor & Allied Subcategories</h5>
            <p class="card-subtitle">Secondary subjects under main departments</p>
        </div>
        <form action="<?php echo e(route('admin.subcategories.index')); ?>" method="GET" class="d-flex flex-wrap align-items-center gap-2" id="searchForm">
            <div class="search-box position-relative">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" id="searchInput" placeholder="Search Subcategories..." value="<?php echo e(request('search')); ?>" style="padding-right: 30px;">
                <?php if(request('search')): ?>
                    <button type="button" class="btn-clear-search" onclick="window.location.href='<?php echo e(route('admin.subcategories.index')); ?>'" title="Clear Search">
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
                        <th>Subcategory Name</th>
                        <th>Main Category (Dept)</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="icon-cell">
                                <?php
                                    $gradients = [
                                        'linear-gradient(135deg,#10b981,#34d399)',
                                        'linear-gradient(135deg,#f59e0b,#fbbf24)',
                                        'linear-gradient(135deg,#f43f5e,#fb7185)',
                                        'linear-gradient(135deg,#3b82f6,#60a5fa)',
                                        'linear-gradient(135deg,#8b5cf6,#a78bfa)'
                                    ];
                                    $icons = ['fa-chart-line', 'fa-calculator', 'fa-scale-balanced', 'fa-microscope', 'fa-globe'];
                                    $gradient = $gradients[strlen($subcat->name) % count($gradients)];
                                    $icon = $icons[strlen($subcat->name) % count($icons)];
                                ?>
                                <div class="icon-wrap" style="background:<?php echo e($gradient); ?>;">
                                    <i class="fas <?php echo e($icon); ?>" style="font-size:0.7rem;"></i>
                                </div>
                                <div>
                                    <div class="user-name"><?php echo e($subcat->name); ?></div>
                                    <?php if($subcat->description): ?>
                                        <div class="user-sub" style="font-size: 0.75rem; color: var(--text-muted);"><?php echo e(Str::limit($subcat->description, 30)); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge primary"><i class="fas fa-tags"></i> <?php echo e($subcat->category->name ?? 'N/A'); ?></span>
                        </td>
                        <td>
                            <?php if($subcat->is_active): ?>
                                <span class="badge success"><span class="status-indicator active"></span> Active</span>
                            <?php else: ?>
                                <span class="badge danger"><span class="status-indicator inactive" style="background: var(--danger)"></span> Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-group justify-content-center">
                                <button class="action-btn edit edit-btn" data-bs-toggle="modal" data-bs-target="#editSubCategoryModal"
                                    data-id="<?php echo e($subcat->id); ?>"
                                    data-category-id="<?php echo e($subcat->category_id); ?>"
                                    data-name="<?php echo e($subcat->name); ?>"
                                    data-description="<?php echo e($subcat->description); ?>"
                                    data-status="<?php echo e($subcat->is_active ? '1' : '0'); ?>">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="<?php echo e(route('admin.subcategories.destroy', $subcat->id)); ?>" method="POST" class="m-0 p-0 delete-form d-flex align-items-center">
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
                                <i class="fas fa-layer-group fa-3x text-muted mb-3" style="opacity: 0.2;"></i>
                                <h6 class="text-heading fw-bold">No Subcategories found</h6>
                                <p class="text-muted small">Add your first subcategory to get started.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($subcategories->hasPages()): ?>
            <div class="px-4 py-3 border-top">
                <?php echo e($subcategories->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('modals'); ?>
<!-- ADD SUBCATEGORY MODAL -->
<div class="modal fade" id="addSubCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content premium">
            <div class="modal-head gradient">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Add Subcategory</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <form action="<?php echo e(route('admin.subcategories.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label class="form-label">Main Category</label>
                        <select name="category_id" id="add_category_id" class="form-select" required placeholder="Select Category...">
                            <option value="">Select Category...</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subcategory Name</label>
                        <input type="text" name="name" class="form-input" placeholder="e.g. English, Sociology" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description (Optional)</label>
                        <input type="text" name="description" class="form-input" placeholder="e.g. Minor or Allied subject">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="is_active" id="add_status" value="1" checked style="width: 2.5em; height: 1.25em; cursor: pointer;">
                            <label class="form-check-label ms-2" for="add_status" style="cursor: pointer; padding-top: 3px;">Active Subcategory</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" style="margin-top:4px;">
                        <i class="fas fa-check-circle"></i> Register Subcategory
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT SUBCATEGORY MODAL -->
<div class="modal fade" id="editSubCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content premium">
            <div class="modal-head dark-grad">
                <h5 class="modal-title"><i class="fas fa-pen"></i> Edit Subcategory</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <form id="editSubCategoryForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="form-group">
                        <label class="form-label">Main Category</label>
                        <select name="category_id" id="edit_category_id" class="form-select" required>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subcategory Name</label>
                        <input type="text" name="name" id="edit_name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" id="edit_description" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="is_active" id="edit_status" value="1" style="width: 2.5em; height: 1.25em; cursor: pointer;">
                            <label class="form-check-label ms-2" for="edit_status" style="cursor: pointer; padding-top: 3px;">Active Subcategory</label>
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
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize TomSelect for Categories
        if(document.getElementById('add_category_id')) {
            let addCat = new TomSelect("#add_category_id", {
                create: false,
                controlInput: null,
                maxOptions: null,
                allowEmptyOption: true,
                wrapperClass: 'ts-wrapper form-select ts-category',
                plugins: ['dropdown_input'],
                sortField: { field: "text", direction: "asc" }
            });
            let searchInput = addCat.dropdown.querySelector('input');
            if(searchInput) searchInput.setAttribute('placeholder', 'Search category...');
        }
        
        if(document.getElementById('edit_category_id')) {
            window.editCatSelect = new TomSelect("#edit_category_id", {
                create: false,
                controlInput: null,
                maxOptions: null,
                allowEmptyOption: true,
                wrapperClass: 'ts-wrapper form-select ts-category',
                plugins: ['dropdown_input'],
                sortField: { field: "text", direction: "asc" }
            });
            let searchInput = window.editCatSelect.dropdown.querySelector('input');
            if(searchInput) searchInput.setAttribute('placeholder', 'Search category...');
        }

        // Edit Modal Population
        const editButtons = document.querySelectorAll('.edit-btn');
        const editForm = document.getElementById('editSubCategoryForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                
                document.getElementById('edit_name').value = this.getAttribute('data-name');
                document.getElementById('edit_description').value = this.getAttribute('data-description') || '';
                
                if(window.editCatSelect) {
                    window.editCatSelect.setValue(this.getAttribute('data-category-id'));
                } else {
                    document.getElementById('edit_category_id').value = this.getAttribute('data-category-id');
                }
                
                const status = this.getAttribute('data-status');
                document.getElementById('edit_status').checked = (status === '1');
                
                let actionUrl = "<?php echo e(route('admin.subcategories.update', ':id')); ?>";
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/admin/subcategories.blade.php ENDPATH**/ ?>