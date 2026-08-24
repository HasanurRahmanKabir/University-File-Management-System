<?php $__env->startSection('title', 'Dashboard — TeacherHub OBE'); ?>
<?php $__env->startSection('page_title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Banner -->
<div class="hero-banner">
    <div class="hero-inner">
        <div>
            <div class="hero-greeting">Welcome back, <span><?php echo e(Auth::user()->name ?? 'Teacher'); ?></span> 👋</div>
            <div class="hero-sub">Here's an overview of your academic workspace for today.</div>
        </div>
        <div class="hero-pill">
            <i class="fas fa-calendar-check" style="font-size:.7rem;"></i>
            Academic Year: <?php echo e(date('Y')); ?>

        </div>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card sc-green" style="animation-delay:.06s">
        <div class="stat-ico ico-green"><i class="fas fa-book-open"></i></div>
        <div class="stat-body">
            <div class="stat-lbl">Active Courses</div>
            <div class="stat-val" data-count="<?php echo e($activeCoursesCount); ?>"><?php echo e(str_pad($activeCoursesCount, 2, '0', STR_PAD_LEFT)); ?></div>
            <div class="stat-sub">Spring <?php echo e(date('Y')); ?> Semester</div>
        </div>
    </div>
    <div class="stat-card sc-blue" style="animation-delay:.12s">
        <div class="stat-ico ico-blue"><i class="fas fa-user-graduate"></i></div>
        <div class="stat-body">
            <div class="stat-lbl">Total Students</div>
            <div class="stat-val" data-count="<?php echo e($totalStudents); ?>"><?php echo e($totalStudents); ?></div>
            <div class="stat-sub">Across all courses</div>
        </div>
    </div>
    <div class="stat-card sc-purple" style="animation-delay:.18s">
        <div class="stat-ico ico-purple"><i class="fas fa-cloud-upload-alt"></i></div>
        <div class="stat-body">
            <div class="stat-lbl">Total Uploads</div>
            <div class="stat-val" data-count="<?php echo e($totalUploads); ?>"><?php echo e($totalUploads); ?></div>
            <div class="stat-sub">Files & resources</div>
        </div>
    </div>
</div>

<!-- Course Overview Table -->
<div class="d-card" style="animation-delay:.24s">
    <div class="d-card-header">
        <div class="d-card-title">
            <div class="d-card-ico"><i class="fas fa-table-list"></i></div>
            Current Course Overview
        </div>
        <a href="<?php echo e(route('teacher.courses.index')); ?>" class="btn-ghost" style="font-size:.75rem;">
            View All <i class="fas fa-arrow-right" style="font-size:.66rem;"></i>
        </a>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl">
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Title</th>
                        <th>Files</th>
                        <th>Year</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $recentCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><span class="t-code"><?php echo e($course->course_code); ?></span></td>
                        <td><span class="t-name"><?php echo e($course->title); ?></span></td>
                        <td><span class="badge b-blue"><?php echo e($course->materials_count); ?> files</span></td>
                        <td style="color:var(--tx-s);"><?php echo e(date('Y')); ?></td>
                        <td><button class="btn-ico bi-view" title="Quick View" data-bs-toggle="modal" data-bs-target="#viewCourseModal<?php echo e($course->id); ?>"><i class="fas fa-eye"></i></button></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 20px; color: var(--tx-s);">No recent courses found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $__env->startPush('modals'); ?>
<?php $__currentLoopData = $recentCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!-- Quick View Modal for <?php echo e($course->course_code); ?> -->
<div class="modal fade" id="viewCourseModal<?php echo e($course->id); ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header align-items-center" style="border-bottom: 1px solid var(--sb-border); padding: 15px 20px;">
                <h5 class="modal-title d-flex align-items-center gap-2" style="font-size: 1.1rem; font-weight: 600; flex: 1; min-width: 0;">
                    <div class="m-ico d-flex align-items-center justify-content-center flex-shrink-0" style="background: var(--blue-lt); color: var(--blue); width: 32px; height: 32px; font-size: 0.8rem; border-radius: var(--r-xs);"><i class="fas fa-book-open"></i></div>
                    <span class="text-truncate" style="flex: 1; min-width: 0;">Course Snapshot</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="font-size: 0.8rem;"></button>
            </div>
            <div class="modal-body p-3 p-sm-4">
                <div class="text-center mb-4">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 16px; background: linear-gradient(135deg, var(--blue-lt), #e0e7ff); color: var(--blue); font-size: 1.8rem; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h4 class="mb-2 text-wrap text-break" style="font-size: 1.25rem; font-weight: 700; color: var(--tx-main); line-height: 1.4;"><?php echo e($course->title); ?></h4>
                    <span class="badge text-wrap" style="background: var(--bg-body); color: var(--tx-s); border: 1px solid var(--sb-border); font-size: 0.85rem; padding: 6px 12px;"><i class="fas fa-hashtag" style="font-size: 0.7rem; margin-right: 4px;"></i><?php echo e($course->course_code); ?></span>
                </div>
                
                <div style="background: var(--bg-body); border-radius: 12px; padding: 16px; border: 1px solid rgba(0,0,0,0.04);">
                    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-start align-items-sm-center mb-3 pb-3" style="border-bottom: 1px dashed var(--sb-border); gap: 6px;">
                        <span style="color: var(--tx-s); font-size: 0.85rem; font-weight: 500;"><i class="fas fa-building" style="margin-right: 6px; opacity: 0.7;"></i> Department</span>
                        <span class="text-wrap text-break text-start text-sm-end" style="font-weight: 600; color: var(--tx-main); font-size: 0.85rem;"><?php echo e($course->department->name ?? 'N/A'); ?></span>
                    </div>
                    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-start align-items-sm-center mb-3 pb-3" style="border-bottom: 1px dashed var(--sb-border); gap: 6px;">
                        <span style="color: var(--tx-s); font-size: 0.85rem; font-weight: 500;"><i class="fas fa-users" style="margin-right: 6px; opacity: 0.7;"></i> Total Students</span>
                        <span class="text-wrap text-break text-start text-sm-end" style="font-weight: 600; color: var(--tx-main); font-size: 0.85rem;"><?php echo e($course->enrolled_students ?? 0); ?> Students</span>
                    </div>
                    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-start align-items-sm-center" style="gap: 6px;">
                        <span style="color: var(--tx-s); font-size: 0.85rem; font-weight: 500;"><i class="fas fa-file-alt" style="margin-right: 6px; opacity: 0.7;"></i> Total Materials</span>
                        <span class="badge b-blue align-self-start align-self-sm-end" style="font-size: 0.85rem; padding: 5px 10px;"><?php echo e($course->materials_count); ?> Files</span>
                    </div>
                </div>
        </div>
    </div>
</div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views\teacher\dashboard.blade.php ENDPATH**/ ?>