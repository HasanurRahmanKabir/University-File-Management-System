<?php $__env->startSection('title', 'Dashboard - Admin Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('breadcrumb', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Welcome Banner -->
            <div class="welcome-banner">
                <div class="welcome-content">
                    <div class="welcome-greeting">
                        <?php
                            $hour = now()->format('H');
                            if ($hour < 12) {
                                $greeting = 'Good morning';
                                $icon = 'fas fa-sun';
                            } elseif ($hour < 17) {
                                $greeting = 'Good afternoon';
                                $icon = 'fas fa-cloud-sun';
                            } else {
                                $greeting = 'Good evening';
                                $icon = 'fas fa-moon';
                            }
                        ?>
                        <i class="<?php echo e($icon); ?>"></i> <?php echo e($greeting); ?>,
                    </div>
                    <h2 class="welcome-title">Welcome back, <?php echo e(Auth::user()->name ?? 'Admin'); ?>!</h2>
                    <p class="welcome-desc">Here's what's happening across your university management system today.</p>
                    <div class="welcome-date">
                        <i class="far fa-calendar-alt"></i>
                        <span id="currentDate"><?php echo e(\Carbon\Carbon::now()->format('l, jS F Y')); ?></span>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon-wrap blue"><i class="fas fa-user-graduate"></i></div>
                    <div class="stat-info">
                        <div class="stat-label">Total Students</div>
                        <div class="stat-number"><?php echo e($stats['students']); ?></div>
                        <div class="stat-trend <?php echo e($trends['students'] >= 0 ? 'up' : 'down'); ?>"><i class="fas fa-arrow-<?php echo e($trends['students'] >= 0 ? 'up' : 'down'); ?>"></i> <?php echo e(abs($trends['students'])); ?>% from last month</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap purple"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="stat-info">
                        <div class="stat-label">Faculty Members</div>
                        <div class="stat-number"><?php echo e($stats['teachers']); ?></div>
                        <div class="stat-trend <?php echo e($trends['teachers'] >= 0 ? 'up' : 'down'); ?>"><i class="fas fa-arrow-<?php echo e($trends['teachers'] >= 0 ? 'up' : 'down'); ?>"></i> <?php echo e(abs($trends['teachers'])); ?>% from last month</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap emerald"><i class="fas fa-book-open"></i></div>
                    <div class="stat-info">
                        <div class="stat-label">Active Courses</div>
                        <div class="stat-number"><?php echo e($stats['courses']); ?></div>
                        <div class="stat-trend <?php echo e($trends['courses'] >= 0 ? 'up' : 'down'); ?>"><i class="fas fa-arrow-<?php echo e($trends['courses'] >= 0 ? 'up' : 'down'); ?>"></i> <?php echo e(abs($trends['courses'])); ?>% from last month</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap amber"><i class="fas fa-folder-open"></i></div>
                    <div class="stat-info">
                        <div class="stat-label">Course Files</div>
                        <div class="stat-number"><?php echo e($stats['files']); ?></div>
                        <div class="stat-trend <?php echo e($trends['files'] >= 0 ? 'up' : 'down'); ?>"><i class="fas fa-arrow-<?php echo e($trends['files'] >= 0 ? 'up' : 'down'); ?>"></i> <?php echo e(abs($trends['files'])); ?>% from last month</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="<?php echo e(route('admin.student-info.index')); ?>" class="quick-action-card">
                    <div class="qa-icon" style="background: #eff6ff; color: #3b82f6;"><i class="fas fa-user-plus"></i></div>
                    <div class="qa-text">
                        <div class="qa-title">Add Student</div>
                        <div class="qa-desc">Register & enroll</div>
                    </div>
                </a>
                <a href="<?php echo e(route('admin.teacher-info.index')); ?>" class="quick-action-card">
                    <div class="qa-icon" style="background: #f5f3ff; color: #8b5cf6;"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="qa-text">
                        <div class="qa-title">Add Teacher</div>
                        <div class="qa-desc">Assign courses</div>
                    </div>
                </a>
                <a href="<?php echo e(route('admin.courses.index')); ?>" class="quick-action-card">
                    <div class="qa-icon" style="background: #ecfdf5; color: #10b981;"><i class="fas fa-book-open"></i></div>
                    <div class="qa-text">
                        <div class="qa-title">New Course</div>
                        <div class="qa-desc">Add to registry</div>
                    </div>
                </a>
                <a href="<?php echo e(route('admin.course-materials.index')); ?>" class="quick-action-card">
                    <div class="qa-icon" style="background: #fffbeb; color: #f59e0b;"><i class="fas fa-cloud-upload-alt"></i></div>
                    <div class="qa-text">
                        <div class="qa-title">Upload File</div>
                        <div class="qa-desc">Course materials</div>
                    </div>
                </a>
            </div>

            <!-- Two Column: Table + Activity -->
            <div class="grid-2col">
                <!-- Management Log -->
                <div class="data-card">
                    <div class="card-header">
                        <div>
                            <h5 class="card-title"><i class="fas fa-clipboard-list"></i> Recent Records</h5>
                            <p class="card-subtitle">Latest entries across the system</p>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="search-box">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" placeholder="Search records...">
                            </div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">Add New</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrap">
                            <table class="premium-table">
                                <thead>
                                    <tr>
                                        <th>Identity</th>
                                        <th>Role</th>
                                        <th>Assignment</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $recentRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <div class="avatar-sm <?php echo e($record->role == 'admin' ? 'rose' : ($record->role == 'teacher' ? 'emerald' : 'blue')); ?>">
                                                    <?php echo e(strtoupper(substr($record->name, 0, 2))); ?>

                                                </div>
                                                <div>
                                                    <div class="user-name"><?php echo e($record->name); ?></div>
                                                    <div class="user-sub"><?php echo e($record->email); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($record->role == 'admin'): ?>
                                                <span class="badge dark"><i class="fas fa-shield-halved"></i> Admin</span>
                                            <?php elseif($record->role == 'teacher'): ?>
                                                <span class="badge success"><i class="fas fa-chalkboard-teacher"></i> Teacher</span>
                                            <?php else: ?>
                                                <span class="badge primary"><i class="fas fa-user-graduate"></i> Student</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="badge neutral"><?php echo e($record->student_id ?? 'N/A'); ?></span></td>
                                        <td>
                                            <div class="action-group">
                                                <button class="action-btn edit" data-bs-toggle="modal" data-bs-target="#editModal" 
                                                    data-id="<?php echo e($record->id); ?>" 
                                                    data-name="<?php echo e($record->name); ?>" 
                                                    data-role="<?php echo e($record->role); ?>" 
                                                    data-reference="<?php echo e(str_contains($record->email, '@') ? $record->email : $record->student_id); ?>">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <form action="<?php echo e(route('admin.dashboard.delete', $record->id)); ?>" method="POST" class="m-0 p-0 delete-form" style="display: flex; align-items: center;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="button" class="action-btn delete delete-btn"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No recent records found.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="data-card">
                    <div class="card-header">
                        <div>
                            <h5 class="card-title"><i class="fas fa-clock-rotate-left"></i> Recent Activity</h5>
                            <p class="card-subtitle">System updates & actions</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="activity-list">
                            <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="activity-item">
                                <div class="activity-dot <?php echo e(['green', 'blue', 'purple', 'amber', 'red'][rand(0, 4)]); ?>"></div>
                                <div class="activity-text"><?php echo $activity->description; ?></div>
                                <div class="activity-time"><?php echo e($activity->created_at->diffForHumans()); ?></div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="activity-item">
                                <div class="activity-text">No recent activities.</div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('modals'); ?>
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content premium">
                <div class="modal-head dark-grad">
                    <h5 class="modal-title"><i class="fas fa-pen"></i> Edit Record</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
                </div>
                <div class="modal-body-content">
                    <form id="editRecordForm" method="POST" action="">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-input" name="name" id="edit_name" required>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Role Type</label>
                                <select class="form-select" name="role" id="edit_role" required>
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">ID / Reference</label>
                                <input type="text" class="form-input" name="reference" id="edit_reference" required>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== ADD MODAL ====== -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content premium">
                <div class="modal-head gradient">
                    <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Create New Record</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
                </div>
                <div class="modal-body-content">
                    <form method="POST" action="<?php echo e(route('admin.dashboard.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label class="form-label">Classification</label>
                            <select class="form-select" name="classification" required>
                                <option value="Student">Student</option>
                                <option value="Teacher">Teacher</option>
                                <option value="Admin">Admin</option>
                                <option value="Course">Course</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Full Name / Title</label>
                            <input type="text" class="form-input" name="name" placeholder="Enter name..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">ID / Email / Course Code</label>
                            <input type="text" class="form-input" name="id_email" placeholder="Enter ID or Email..." required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" style="margin-top: 4px;">
                            <i class="fas fa-check-circle"></i> Confirm and Add
                        </button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Modal Population
        const editButtons = document.querySelectorAll('.action-btn.edit');
        const editForm = document.getElementById('editRecordForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const role = this.getAttribute('data-role');
                const reference = this.getAttribute('data-reference');
                
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_role').value = role;
                document.getElementById('edit_reference').value = reference;
                
                // Set the form action URL dynamically
                let actionUrl = "<?php echo e(route('admin.dashboard.update', ':id')); ?>";
                editForm.action = actionUrl.replace(':id', id);
            });
        });

        // Delete Confirmation with SweetAlert
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this record!",
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

        // --- SweetAlert2 Toast Notifications ---
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            background: 'var(--bg-card)',
            color: 'var(--text-heading)',
            customClass: { popup: 'premium-toast' },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>