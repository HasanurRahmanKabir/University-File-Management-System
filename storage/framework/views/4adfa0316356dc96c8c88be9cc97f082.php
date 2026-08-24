<?php $__env->startSection('title', 'My Course Info — TeacherHub OBE'); ?>
<?php $__env->startSection('page_title', 'My Course Info'); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats -->
<div class="stats-grid mb-4">
    <div class="stat-card sc-green" style="animation-delay:.06s">
        <div class="stat-ico ico-green"><i class="fas fa-circle-play"></i></div>
        <div class="stat-body">
            <div class="stat-lbl">Running Semester</div>
            <div class="stat-val" style="font-size: 1.4rem;">Spring <?php echo e(date('Y')); ?></div>
            <div class="stat-sub">Current Academic Session</div>
        </div>
    </div>
    <div class="stat-card sc-blue" style="animation-delay:.12s">
        <div class="stat-ico ico-blue"><i class="fas fa-book-open"></i></div>
        <div class="stat-body">
            <div class="stat-lbl">Active Courses</div>
            <div class="stat-val" data-count="<?php echo e($activeCoursesCount); ?>"><?php echo e(str_pad($activeCoursesCount, 2, '0', STR_PAD_LEFT)); ?></div>
            <div class="stat-sub">Currently assigned</div>
        </div>
    </div>
    <div class="stat-card sc-purple" style="animation-delay:.18s">
        <div class="stat-ico ico-purple"><i class="fas fa-users"></i></div>
        <div class="stat-body">
            <div class="stat-lbl">Total Students</div>
            <div class="stat-val" data-count="<?php echo e($totalStudents); ?>"><?php echo e($totalStudents); ?></div>
            <div class="stat-sub">Across all courses</div>
        </div>
    </div>
</div>

<!-- Running Semester -->
<div class="d-card" style="animation-delay:.06s">
    <div class="d-card-header">
        <div class="d-card-title">
            <div class="d-card-ico" style="background:var(--success-lt);color:var(--success);"><i class="fas fa-circle-play"></i></div>
            Running Semester
        </div>
        <span class="badge b-green" style="padding:5px 12px;">Spring <?php echo e(date('Y')); ?></span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl">
                <thead><tr><th>Code</th><th>Course Title</th><th>Credit</th><th>Students</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $runningCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><span class="t-code"><?php echo e($course->course_code); ?></span></td>
                        <td><span class="t-name"><?php echo e($course->title); ?></span></td>
                        <td><span class="badge b-gray"><?php echo e($course->credit ?? 'N/A'); ?></span></td>
                        <td><span style="font-weight:600;color:var(--tx-h);"><?php echo e($course->enrolled_students); ?></span> <span style="color:var(--tx-m);font-size:.75rem;">students</span></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4">
                            <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding: 40px 20px; text-align: center;">
                                <div class="empty-ico" style="font-size: 3rem; color: var(--bd-dark, #cbd5e1); margin-bottom: 15px;"><i class="fas fa-folder-open"></i></div>
                                <h5 style="color: var(--tx-h); font-weight: 600; margin-bottom: 5px;">No Running Courses</h5>
                                <p style="color: var(--tx-m); font-size: 0.9rem; max-width: 400px; margin: 0 auto;">There are no active courses assigned to you for the current semester.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Previous Semester -->
<div class="d-card" style="animation-delay:.12s">
    <div class="d-card-header">
        <div class="d-card-title">
            <div class="d-card-ico" style="background:var(--bg-muted);color:var(--tx-s);"><i class="fas fa-clock-rotate-left"></i></div>
            Previous Semester Records
        </div>
        <span class="badge b-gray" style="padding:5px 12px;">Archived</span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl">
                <thead><tr><th>Semester</th><th>Course Code</th><th>Course Title</th><th>Year</th><th>Status</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $previousCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><span class="badge b-purple">Fall</span></td>
                        <td><span class="t-code"><?php echo e($course->course_code); ?></span></td>
                        <td><span class="t-name"><?php echo e($course->title); ?></span></td>
                        <td style="color:var(--tx-s);"><?php echo e($course->created_at->format('Y')); ?></td>
                        <td><span class="badge b-green"><i class="fas fa-check" style="margin-right:4px;"></i>Completed</span></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5">
                            <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding: 40px 20px; text-align: center;">
                                <div class="empty-ico" style="font-size: 3rem; color: var(--bd-dark, #cbd5e1); margin-bottom: 15px;"><i class="fas fa-box-archive"></i></div>
                                <h5 style="color: var(--tx-h); font-weight: 600; margin-bottom: 5px;">No Previous Semester Courses</h5>
                                <p style="color: var(--tx-m); font-size: 0.9rem; max-width: 400px; margin: 0 auto;">You have no completed or archived courses from previous semesters.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views\teacher\mycourseinfo.blade.php ENDPATH**/ ?>