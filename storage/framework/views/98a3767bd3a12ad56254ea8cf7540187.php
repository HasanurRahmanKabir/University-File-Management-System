<?php $__env->startSection('title', 'University Announcements - Admin Dashboard'); ?>
<?php $__env->startSection('page-title', 'University Announcements'); ?>
<?php $__env->startSection('breadcrumb', 'University Announcements'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .premium-table th, .premium-table td {
        padding: 15px 20px;
        vertical-align: middle;
    }
    .badge-custom {
        font-size: 0.75rem;
        padding: 0.4em 0.8em;
        border-radius: 20px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        justify-content: center;
    }
    table { table-layout: fixed; width: 100%; }
    th { color: var(--tx-m); font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid var(--border-color); }
    .col-teacher { width: 16.66%; text-align: left !important; }
    .col-type { width: 16.66%; text-align: center !important; }
    .col-title { width: 16.66%; text-align: center !important; }
    .col-details { width: 16.66%; text-align: center !important; }
    .col-date { width: 16.66%; text-align: center !important; }
    .col-action { width: 16.66%; text-align: right !important; }
    
    .teacher-info img {
        width: 36px;
        height: 36px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid var(--border-color);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div class="heading-group">
        <h2>University Announcements</h2>
        <p>Monitor and manage all class notices and announcements across the university.</p>
    </div>
</div>

<div class="data-card">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5 class="card-title"><i class="fas fa-broadcast-tower text-primary"></i> All Announcements</h5>
            <p class="card-subtitle">Showing all recent teacher announcements</p>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-wrap table-responsive">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th class="col-teacher">Teacher & Course</th>
                        <th class="col-type">Type</th>
                        <th class="col-title">Title</th>
                        <th class="col-details">Details</th>
                        <th class="col-date">Date/Deadline</th>
                        <th class="col-action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="col-teacher">
                            <div class="d-flex align-items-center gap-3 teacher-info">
                                <?php if(optional($announcement->teacher)->profile_image): ?>
                                    <img src="<?php echo e(asset('storage/' . $announcement->teacher->profile_image)); ?>" alt="Teacher">
                                <?php else: ?>
                                    <div class="avatar-placeholder" style="width:36px;height:36px;border-radius:50%;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:0.9rem;">
                                        <?php echo e(strtoupper(substr(optional($announcement->teacher)->name ?? 'U', 0, 1))); ?>

                                    </div>
                                <?php endif; ?>
                                <div>
                                    <p class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;"><?php echo e(optional($announcement->teacher)->name ?? 'Unknown Teacher'); ?></p>
                                    <small class="text-muted" style="font-size: 0.8rem;">
                                        <i class="fas fa-book-open"></i> <?php echo e(optional($announcement->course)->course_code ?? 'Course N/A'); ?>

                                    </small>
                                </div>
                            </div>
                        </td>
                        <td class="col-type">
                            <?php if($announcement->type == 'Assignment'): ?>
                                <span class="badge bg-warning text-dark badge-custom"><i class="fas fa-tasks"></i> Assignment</span>
                            <?php elseif($announcement->type == 'Class Test (CT)'): ?>
                                <span class="badge bg-danger badge-custom"><i class="fas fa-edit"></i> CT</span>
                            <?php elseif($announcement->type == 'Exam'): ?>
                                <span class="badge bg-primary badge-custom"><i class="fas fa-graduation-cap"></i> Exam</span>
                            <?php else: ?>
                                <span class="badge bg-info text-dark badge-custom"><i class="fas fa-info-circle"></i> Notice</span>
                            <?php endif; ?>
                        </td>
                        <td class="col-title">
                            <span class="text-dark fw-bold" style="font-size: 0.9rem;"><?php echo e($announcement->title); ?></span>
                        </td>
                        <td class="col-details">
                            <span class="text-muted" style="font-size: 0.85rem;" title="<?php echo e($announcement->topic_details); ?>">
                                <?php echo e(\Illuminate\Support\Str::limit($announcement->topic_details, 40)); ?>

                            </span>
                        </td>
                        <td class="col-date">
                            <?php if($announcement->deadline): ?>
                                <div class="text-warning fw-bold" style="font-size:0.8rem;">
                                    <i class="fas fa-clock"></i> <?php echo e($announcement->deadline->format('d M Y, h:i A')); ?>

                                </div>
                            <?php elseif($announcement->exam_date): ?>
                                <div class="text-danger fw-bold" style="font-size:0.8rem;">
                                    <i class="fas fa-calendar-alt"></i> <?php echo e($announcement->exam_date->format('d M Y, h:i A')); ?>

                                </div>
                            <?php else: ?>
                                <span class="text-muted" style="font-size: 0.85rem;">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="col-action">
                            <form action="<?php echo e(route('admin.announcements.destroy', $announcement->id)); ?>" method="POST" class="d-inline delete-form">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="button" class="btn btn-sm btn-icon btn-danger delete-btn" title="Delete Announcement">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding: 60px 20px;">
                                <div class="empty-ico" style="font-size: 4rem; color: var(--border-color); margin-bottom: 20px;">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <h5 class="fw-bold" style="color: var(--tx-h);">No Announcements Found</h5>
                                <p class="text-muted" style="max-width: 400px; margin: 0 auto; text-align: center;">There are no active course announcements in the system.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php if($announcements->hasPages()): ?>
    <div class="card-footer bg-transparent border-top p-3 d-flex justify-content-center">
        <?php echo e($announcements->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // SweetAlert for Delete
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "This announcement will be permanently deleted from the entire system!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#cbd5e1',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

<?php echo $__env->make('partials.sweetalert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/admin/announcements/index.blade.php ENDPATH**/ ?>