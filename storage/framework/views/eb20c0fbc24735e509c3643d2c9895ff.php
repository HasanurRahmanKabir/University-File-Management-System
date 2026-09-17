<?php $__env->startSection('title', 'Semesters - Admin Dashboard'); ?>
<?php $__env->startSection('page-title', 'Academic Semesters'); ?>
<?php $__env->startSection('breadcrumb', 'Semesters'); ?>

<?php $__env->startPush('styles'); ?>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
    /* Ensure TomSelect perfectly matches the standard form-select design */
    .ts-wrapper.form-select { padding: 0 !important; border: none !important; background: transparent !important; box-shadow: none !important; }
    .ts-control { border: 1.5px solid var(--border) !important; border-radius: var(--radius-md) !important; background: var(--bg-input) !important; color: var(--text-body) !important; font-size: 0.85rem !important; padding: 9px 13px !important; min-height: 42px !important; box-shadow: var(--shadow-sm) !important; display: flex; flex-wrap: wrap; align-items: center; gap: 4px; transition: all var(--duration-base) var(--ease); }
    .ts-wrapper.focus .ts-control { border-color: var(--primary) !important; box-shadow: 0 0 0 3px var(--primary-glow) !important; background: white !important; outline: none !important; }
    /* TomSelect Placeholders */
    .ts-dropdown { border: 1px solid var(--border) !important; border-radius: var(--radius-md) !important; background-color: white !important; box-shadow: var(--shadow-md) !important; z-index: 9999 !important; }
    .ts-dropdown .ts-dropdown-content { max-height: 250px !important; overflow-y: auto !important; padding-bottom: 5px; }
    .ts-dropdown .option[data-value=""] { display: none !important; }
    .ts-dropdown .option { padding: 8px 14px !important; color: var(--text-body) !important; font-size: 0.85rem !important; }
    .ts-dropdown .option:hover, .ts-dropdown .active { background-color: var(--bg-muted) !important; color: var(--primary) !important; }
    .ts-dropdown .dropdown-input-wrap { padding: 8px !important; border-bottom: 1px solid var(--border-light) !important; }
    .ts-dropdown .dropdown-input { border: 1px solid var(--border) !important; border-radius: var(--radius-sm) !important; padding: 6px 12px !important; background: var(--bg-muted) !important; color: var(--text-body) !important; font-size: 0.85rem !important; }
    .ts-control::after { content: ""; display: block; width: 10px; height: 10px; border-right: 2px solid #888; border-bottom: 2px solid #888; transform: rotate(45deg); position: absolute; right: 15px; top: 40%; transition: transform 0.2s ease; }
    .ts-wrapper.dropdown-active .ts-control::after { transform: rotate(-135deg); top: 45%; }
    .ts-wrapper.dropdown-active .ts-control .item, .ts-wrapper.has-items .ts-control .item { display: block !important; opacity: 1 !important; }
    
    /* Premium Multi-select tweaks matching Teacher Courses */
    .ts-wrapper.multi { padding: 0 !important; border: none !important; background-color: transparent !important; box-shadow: none !important; }
    .ts-wrapper.multi .ts-control { display: flex; align-items: center; flex-wrap: wrap; gap: 6px; padding: 9px 30px 9px 13px !important; min-height: 42px !important; position: relative; }
    .ts-wrapper.multi .ts-control::after { display: block !important; } /* Keep the dropdown arrow */
    .ts-wrapper.multi .ts-control .item { background: #e0f2fe; color: #0284c7; border: none; border-radius: 4px; padding: 4px 10px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; z-index: 2; }
    .ts-wrapper.multi .ts-control .item.active { background: #bae6fd; }
    
    /* Fake placeholder for multi-select with dropdown_input */
    .ts-wrapper.multi:not(.has-items) .ts-control::before {
        content: attr(data-placeholder);
        color: var(--text-muted);
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        font-size: 0.85rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="heading-group">
        <h2>Semester Management</h2>
        <p>Manage all academic semesters and their durations.</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSemesterModal">
        <i class="fas fa-plus-circle"></i> Add Semester
    </button>
</div>

<div class="data-card">
    <div class="card-header">
        <div>
            <h5 class="card-title"><i class="fas fa-calendar-alt"></i> Academic Semesters</h5>
            <p class="card-subtitle">List of all registered academic semesters</p>
        </div>
        <form action="<?php echo e(route('admin.semesters.index')); ?>" method="GET" class="d-flex align-items-center gap-2" id="searchForm">
            <div class="search-box position-relative">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" id="searchInput" placeholder="Search by name or year..." value="<?php echo e(request('search')); ?>" style="padding-right: 30px;">
                <?php if(request('search')): ?>
                    <button type="button" class="btn-clear-search" onclick="window.location.href='<?php echo e(route('admin.semesters.index')); ?>'" title="Clear Search">
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
                        <th>Semester Name</th>
                        <th class="text-center">Departments</th>
                        <th class="text-center">Year</th>
                        <th class="text-center">Duration</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="user-cell">
                                <?php $colors = ['blue', 'purple', 'emerald', 'amber', 'rose', 'cyan', 'indigo', 'slate']; ?>
                                <div class="avatar-sm <?php echo e($colors[strlen($semester->name) % 8]); ?> d-flex align-items-center justify-content-center text-white fw-bold">
                                    <?php echo e(strtoupper(substr($semester->name, 0, 1))); ?>

                                </div>
                                <div>
                                    <div class="user-name"><?php echo e($semester->name); ?></div>
                                    <div class="user-sub">Academic Term</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center" style="max-width: 250px;">
                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                <?php $__empty_2 = true; $__currentLoopData = $semester->departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                    <span class="badge" style="background: #e0f2fe; color: #0284c7; margin-bottom: 2px;"><i class="fas fa-building"></i> <?php echo e($dept->name); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                    <span class="badge neutral"><i class="fas fa-globe"></i> Global/None</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="text-center"><span style="color:var(--text-secondary);font-weight:600;"><?php echo e($semester->year ?? 'N/A'); ?></span></td>
                        <td class="text-center">
                            <?php if($semester->start_date && $semester->end_date): ?>
                                <span class="badge neutral"><i class="fas fa-calendar"></i> <?php echo e(\Carbon\Carbon::parse($semester->start_date)->format('M d, Y')); ?> - <?php echo e(\Carbon\Carbon::parse($semester->end_date)->format('M d, Y')); ?></span>
                            <?php elseif($semester->start_date): ?>
                                <span class="badge neutral"><i class="fas fa-calendar"></i> Starts: <?php echo e(\Carbon\Carbon::parse($semester->start_date)->format('M d, Y')); ?></span>
                            <?php elseif($semester->end_date): ?>
                                <span class="badge neutral"><i class="fas fa-calendar"></i> Ends: <?php echo e(\Carbon\Carbon::parse($semester->end_date)->format('M d, Y')); ?></span>
                            <?php else: ?>
                                <span class="text-muted small">Not specified</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if($semester->is_active): ?>
                                <span class="badge success"><i class="fas fa-check-circle"></i> Active</span>
                            <?php else: ?>
                                <span class="badge danger"><i class="fas fa-times-circle"></i> Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-group">
                                <button class="action-btn edit edit-semester-btn" data-bs-toggle="modal" data-bs-target="#editSemesterModal"
                                    data-id="<?php echo e($semester->id); ?>"
                                    data-name="<?php echo e($semester->name); ?>"
                                    data-year="<?php echo e($semester->year); ?>"
                                    data-start="<?php echo e($semester->start_date); ?>"
                                    data-end="<?php echo e($semester->end_date); ?>"
                                    data-departments="<?php echo e(json_encode($semester->departments->pluck('id'))); ?>"
                                    data-active="<?php echo e($semester->is_active ? 1 : 0); ?>">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="<?php echo e(route('admin.semesters.destroy', $semester->id)); ?>" method="POST" class="m-0 p-0 delete-form d-flex align-items-center">
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
                                    <p class="text-muted small">We couldn't find any semester matching your criteria.</p>
                                    <a href="<?php echo e(route('admin.semesters.index')); ?>" class="btn btn-sm btn-primary mt-3">Clear Search</a>
                                <?php else: ?>
                                    <h6 class="text-heading fw-bold">No semesters found</h6>
                                    <p class="text-muted small">Add your first academic semester to get started.</p>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($semesters->hasPages()): ?>
            <div class="mt-3 px-3 pb-3 border-top pt-3">
                <?php echo e($semesters->links('pagination::bootstrap-5')); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('modals'); ?>
<!-- ADD SEMESTER MODAL -->
<div class="modal fade" id="addSemesterModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content premium">
            <div class="modal-head gradient">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Add Semester</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <form action="<?php echo e(route('admin.semesters.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label class="form-label">Semester Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-input" placeholder="Enter Semester Name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Departments <span class="text-danger">*</span></label>
                        <select name="department_ids[]" id="add_department" class="form-select" multiple required>
                            <option value="">Select Departments</option>
                            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($dept->id); ?>"><?php echo e($dept->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Year</label>
                        <input type="number" name="year" class="form-input" placeholder="Enter Year" min="2000" max="2100">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-input">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-input">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="custom-switch-container" style="margin-top: 8px;">
                            <label class="custom-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" checked>
                                <span class="switch-slider"></span>
                            </label>
                            <span class="switch-label text-muted small fw-bold">Active</span>
                        </div>
                    </div>
                    <div style="display:flex; justify-content:center; gap:12px; margin-top:24px;">
                        <button type="button" class="btn btn-light" style="padding:10px 32px; font-weight:600; border: 1px solid #cbd5e1; background-color: #f1f5f9; color: #334155; box-shadow: 0 2px 4px rgba(0,0,0,0.05);" data-bs-dismiss="modal" onmouseover="this.style.backgroundColor='#e2e8f0'" onmouseout="this.style.backgroundColor='#f1f5f9'"><i class="fas fa-times"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary" style="padding:10px 48px;"><i class="fas fa-check-circle"></i> Save Semester</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT SEMESTER MODAL -->
<div class="modal fade" id="editSemesterModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content premium">
            <div class="modal-head dark-grad">
                <h5 class="modal-title"><i class="fas fa-pen"></i> Edit Semester</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <form id="editSemesterForm" action="" method="POST">
                    <?php echo csrf_field(); ?> 
                    <?php echo method_field('PUT'); ?>
                    <div class="form-group">
                        <label class="form-label">Semester Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-input" placeholder="Enter Semester Name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Departments <span class="text-danger">*</span></label>
                        <select name="department_ids[]" id="edit_department" class="form-select" multiple required>
                            <option value="">Select Departments</option>
                            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($dept->id); ?>"><?php echo e($dept->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Year</label>
                        <input type="number" name="year" id="edit_year" class="form-input" placeholder="Enter Year" min="2000" max="2100">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="edit_start" class="form-input">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" id="edit_end" class="form-input">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="custom-switch-container" style="margin-top: 8px;">
                            <label class="custom-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" id="edit_is_active" value="1">
                                <span class="switch-slider"></span>
                            </label>
                            <span class="switch-label text-muted small fw-bold">Active</span>
                        </div>
                    </div>
                    <div style="display:flex; justify-content:center; gap:12px; margin-top:24px;">
                        <button type="button" class="btn btn-light" style="padding:10px 32px; font-weight:600; border: 1px solid #cbd5e1; background-color: #f1f5f9; color: #334155; box-shadow: 0 2px 4px rgba(0,0,0,0.05);" data-bs-dismiss="modal" onmouseover="this.style.backgroundColor='#e2e8f0'" onmouseout="this.style.backgroundColor='#f1f5f9'"><i class="fas fa-times"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary" style="padding:10px 48px;"><i class="fas fa-check-circle"></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<style>
    /* Switch styles */
    .custom-switch-container { display: flex; align-items: center; gap: 10px; }
    .custom-switch { position: relative; display: inline-block; width: 48px; height: 24px; }
    .custom-switch input { opacity: 0; width: 0; height: 0; }
    .switch-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .4s; border-radius: 24px; }
    .switch-slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
    input:checked + .switch-slider { background-color: var(--primary); }
    input:checked + .switch-slider:before { transform: translateX(24px); }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Modal Population
        const editButtons = document.querySelectorAll('.edit-semester-btn');
        const editForm = document.getElementById('editSemesterForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('edit_name').value = this.getAttribute('data-name');
                document.getElementById('edit_year').value = this.getAttribute('data-year');
                document.getElementById('edit_start').value = this.getAttribute('data-start');
                document.getElementById('edit_end').value = this.getAttribute('data-end');
                document.getElementById('edit_is_active').checked = this.getAttribute('data-active') === '1';
                
                if (window.editDeptSelect) {
                    try {
                        const depts = JSON.parse(this.getAttribute('data-departments') || '[]');
                        window.editDeptSelect.setValue(depts);
                    } catch(e) {
                        console.error("Error parsing departments JSON", e);
                    }
                }
                
                let actionUrl = "<?php echo e(route('admin.semesters.update', ':id')); ?>";
                editForm.action = actionUrl.replace(':id', id);
            });
        });

        // Initialize TomSelect for Departments with dropdown_input and pseudo-placeholder
        const tsMultiConfig = {
            plugins: ['dropdown_input', 'remove_button'],
            create: false,
            maxOptions: null,
            wrapperClass: 'ts-wrapper form-select multi',
            sortField: { field: "text", direction: "asc" }
        };

        if(document.getElementById('add_department')) {
            window.addDeptSelect = new TomSelect('#add_department', tsMultiConfig);
            window.addDeptSelect.control.setAttribute('data-placeholder', 'Select Departments');
            let searchInputAdd = window.addDeptSelect.dropdown.querySelector('input');
            if(searchInputAdd) searchInputAdd.setAttribute('placeholder', 'Search departments...');
        }
        
        if(document.getElementById('edit_department')) {
            window.editDeptSelect = new TomSelect('#edit_department', tsMultiConfig);
            window.editDeptSelect.control.setAttribute('data-placeholder', 'Select Departments');
            let searchInputEdit = window.editDeptSelect.dropdown.querySelector('input');
            if(searchInputEdit) searchInputEdit.setAttribute('placeholder', 'Search departments...');
        }

        // Delete Confirmation
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This semester will be permanently deleted!",
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

        <?php if($errors->any()): ?>
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: "<?php echo e($errors->first()); ?>",
                confirmButtonColor: 'var(--primary)',
                background: 'var(--bg-card)',
                color: 'var(--text-heading)'
            });
        <?php endif; ?>

        <?php if(session('success')): ?>
            Toast.fire({
                icon: 'success',
                title: "<?php echo e(session('success')); ?>"
            });
        <?php endif; ?>
        
        <?php if(session('error')): ?>
            Toast.fire({
                icon: 'error',
                title: "<?php echo e(session('error')); ?>"
            });
        <?php endif; ?>
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/admin/semesters.blade.php ENDPATH**/ ?>