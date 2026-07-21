<?php $__env->startSection('title', 'Admins - Admin Dashboard'); ?>
<?php $__env->startSection('page-title', 'Admin Accounts'); ?>
<?php $__env->startSection('breadcrumb', 'Admin Accounts'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="heading-group"><h2>Authorized Administrators</h2><p>Manage admin accounts, credentials, and access privileges.</p></div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdminModal"><i class="fas fa-user-plus"></i> Add Admin</button>
</div>

<div class="data-card">
    <div class="card-header">
        <div><h5 class="card-title"><i class="fas fa-shield-halved"></i> Admin Accounts</h5><p class="card-subtitle">All users with administrative access</p></div>
        <form action="<?php echo e(route('admin.admins.index')); ?>" method="GET" class="d-flex align-items-center gap-2" id="searchForm">
            <div class="search-box position-relative">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" id="searchInput" placeholder="Search any field..." value="<?php echo e(request('search')); ?>" style="padding-right: 30px;">
                <?php if(request('search')): ?>
                    <button type="button" class="btn-clear-search" onclick="window.location.href='<?php echo e(route('admin.admins.index')); ?>'" title="Clear Search">
                        <i class="fas fa-times"></i>
                    </button>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-weight: 500;">Search</button>
        </form>
    </div>
    <div class="card-body"><div class="table-wrap">
        <table class="premium-table">
            <thead><tr><th>Admin Name</th><th>Email Address</th><th>Contact</th><th>Status</th><th class="text-center">Action</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="user-cell">
                            <?php if($admin->profile_image): ?>
                                <img src="<?php echo e(asset('storage/' . $admin->profile_image)); ?>" alt="<?php echo e($admin->name); ?>" class="avatar-sm" style="object-fit: cover; border-radius: var(--radius-md); flex-shrink: 0;">
                            <?php else: ?>
                                <?php $colors = ['blue', 'purple', 'emerald', 'amber', 'rose', 'cyan', 'indigo', 'slate']; ?>
                                <div class="avatar-sm <?php echo e($colors[strlen($admin->name) % 8]); ?> d-flex align-items-center justify-content-center text-white fw-bold"><?php echo e(strtoupper(substr($admin->name, 0, 2))); ?></div>
                            <?php endif; ?>
                            <div>
                                <div class="user-name"><?php echo e($admin->name); ?></div>
                                <div class="user-sub">Administrator</div>
                            </div>
                        </div>
                    </td>
                    <td><span style="color:var(--text-secondary);font-size:0.82rem;"><?php echo e($admin->email); ?></span></td>
                    <td>
                        <?php if($admin->contact_number): ?>
                            <span class="badge neutral"><i class="fas fa-phone"></i> <?php echo e($admin->contact_number); ?></span>
                        <?php else: ?>
                            <span class="text-muted small">Not provided</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($admin->is_active): ?>
                            <span class="badge success"><i class="fas fa-check-circle"></i> Active</span>
                        <?php else: ?>
                            <span class="badge danger"><i class="fas fa-times-circle"></i> Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="action-group">
                            <button class="action-btn edit edit-admin-btn" data-bs-toggle="modal" data-bs-target="#editAdminModal"
                                data-id="<?php echo e($admin->id); ?>"
                                data-name="<?php echo e($admin->name); ?>"
                                data-email="<?php echo e($admin->email); ?>"
                                data-contact="<?php echo e($admin->contact_number); ?>"
                                data-active="<?php echo e($admin->is_active ? 1 : 0); ?>">
                                <i class="fas fa-pen"></i>
                            </button>
                            <form action="<?php echo e(route('admin.admins.destroy', $admin->id)); ?>" method="POST" class="m-0 p-0 delete-form d-flex align-items-center">
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
                                <p class="text-muted small">We couldn't find any admin matching your search criteria.</p>
                                <a href="<?php echo e(route('admin.admins.index')); ?>" class="btn btn-sm btn-primary mt-3">Clear Search</a>
                            <?php else: ?>
                                <h6 class="text-heading fw-bold">No admins found</h6>
                                <p class="text-muted small">Add your first admin to see them listed here.</p>
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
<div class="modal fade" id="addAdminModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content premium"><div class="modal-head gradient"><h5 class="modal-title"><i class="fas fa-user-plus"></i> Register Admin</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form action="<?php echo e(route('admin.admins.store')); ?>" method="POST"><?php echo csrf_field(); ?>
        <div class="form-group"><label class="form-label">Full Name</label><input type="text" name="name" class="form-input" placeholder="Enter admin name" required></div>
        <div class="form-group"><label class="form-label">Email Address</label><input type="email" name="email" class="form-input" placeholder="admin@system.com" required></div>
        <div class="form-group"><label class="form-label">Contact Number</label><input type="text" name="contact_number" class="form-input" placeholder="+880 1XXX-XXXXXX" required></div>
        <div class="form-group">
            <label class="form-label">Create Password</label>
            <div style="position: relative;">
                <input type="password" name="password" class="form-input" placeholder="Set a secure password" required style="padding-right: 40px;">
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
        <button type="submit" class="btn btn-primary btn-block" style="margin-top:4px;"><i class="fas fa-check-circle"></i> Complete Registration</button>
    </form></div></div></div></div>

    <!-- EDIT ADMIN -->
    <div class="modal fade" id="editAdminModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content premium"><div class="modal-head dark-grad"><h5 class="modal-title"><i class="fas fa-pen"></i> Update Admin</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form id="editAdminForm" action="" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="form-group"><label class="form-label">Full Name</label><input type="text" name="name" id="edit_name" class="form-input" required></div>
        <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" id="edit_email" class="form-input" required></div>
        <div class="form-group"><label class="form-label">Contact</label><input type="text" name="contact_number" id="edit_contact" class="form-input" required></div>
        <div class="form-group">
            <label class="form-label">New Password</label>
            <div style="position: relative;">
                <input type="password" name="password" class="form-input" placeholder="Leave blank to keep current" style="padding-right: 40px;">
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
        <div class="form-actions"><button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Save</button></div>
    </form></div></div></div></div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
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

        // Edit Modal Population
        const editButtons = document.querySelectorAll('.edit-admin-btn');
        const editForm = document.getElementById('editAdminForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('edit_name').value = this.getAttribute('data-name');
                document.getElementById('edit_email').value = this.getAttribute('data-email');
                document.getElementById('edit_contact').value = this.getAttribute('data-contact');
                document.getElementById('edit_is_active').value = this.getAttribute('data-active');
                
                let actionUrl = "<?php echo e(route('admin.admins.update', ':id')); ?>";
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
                    text: "This admin account will be permanently deleted!",
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
            Toast.fire({ icon: 'error', title: "Validation Error", text: "<?php echo e($errors->first()); ?>" });
        <?php endif; ?>
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/admin/admins.blade.php ENDPATH**/ ?>