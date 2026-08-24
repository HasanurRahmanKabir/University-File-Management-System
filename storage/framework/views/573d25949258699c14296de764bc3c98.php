<?php $__env->startSection('title', 'Course Info — StudentHub OBE'); ?>
<?php $__env->startSection('page-title', 'Course Info'); ?>
<?php $__env->startSection('breadcrumb', 'Course Info'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-card" style="animation-delay:.05s">
    <div class="d-card-header">
        <div class="d-card-title">
            <div class="d-card-ico" style="background:#eff6ff;color:#2563eb;"><i class="fas fa-graduation-cap"></i></div>
            My Course Information
        </div>
        <span class="badge b-blue"><i class="fas fa-calendar" style="font-size:.55rem;"></i> <?php echo e(Auth::user()->semester ?? 'Current'); ?></span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl" style="width: 100%; min-width: 840px; text-align: center; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 16.66%; min-width: 140px;">Course Code</th>
                        <th style="text-align: center; width: 16.66%; min-width: 140px;">Course Title</th>
                        <th style="text-align: center; width: 16.66%; min-width: 140px;">Instructor</th>
                        <th style="text-align: center; width: 16.66%; min-width: 140px;">Course Credit</th>
                        <th style="text-align: center; width: 16.66%; min-width: 140px;">Year</th>
                        <th style="text-align: center; width: 16.66%; min-width: 140px;">Semester</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="text-align: center; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><span class="t-code"><?php echo e($course->course_code); ?></span></td>
                        <td style="text-align: center; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><span class="t-name"><?php echo e($course->title ?? $course->course_name ?? 'Course'); ?></span></td>
                        <td style="text-align: center; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color:var(--tx-s);"><?php echo e(optional($course->teacher)->name ?? 'TBA'); ?></td>
                        <td style="text-align: center; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><span class="badge b-gray"><?php echo e($course->credit ?? '3.0 cr'); ?></span></td>
                        <td style="text-align: center; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color:var(--tx-s);"><?php echo e(optional($course->created_at)->format('Y') ?? 'N/A'); ?></td>
                        <td style="text-align: center; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><span class="badge b-blue"><?php echo e(Auth::user()->semester ?? 'Current Semester'); ?></span></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" style="padding: 0; border-bottom: none;">
                            <div class="empty-state">
                                <div class="empty-ico"><i class="fas fa-folder-open"></i></div>
                                <div class="empty-title">No Course Records Found</div>
                                <div class="empty-sub">You are not enrolled in any courses for the current or previous semesters. Please contact your department if this is a mistake.</div>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    <?php echo e($courses->links('pagination::bootstrap-5')); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views\student\courses\index.blade.php ENDPATH**/ ?>