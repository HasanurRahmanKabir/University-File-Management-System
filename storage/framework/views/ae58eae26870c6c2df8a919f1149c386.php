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
            <div class="stat-val" data-count="3">03</div>
            <div class="stat-sub">Spring <?php echo e(date('Y')); ?> Semester</div>
        </div>
    </div>
    <div class="stat-card sc-blue" style="animation-delay:.12s">
        <div class="stat-ico ico-blue"><i class="fas fa-user-graduate"></i></div>
        <div class="stat-body">
            <div class="stat-lbl">Total Students</div>
            <div class="stat-val" data-count="145">145</div>
            <div class="stat-sub">Across all courses</div>
        </div>
    </div>
    <div class="stat-card sc-purple" style="animation-delay:.18s">
        <div class="stat-ico ico-purple"><i class="fas fa-cloud-upload-alt"></i></div>
        <div class="stat-body">
            <div class="stat-lbl">Total Uploads</div>
            <div class="stat-val" data-count="24">24</div>
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
                    <tr>
                        <td><span class="t-code">CSE-0400</span></td>
                        <td><span class="t-name">System Design Project</span></td>
                        <td><span class="badge b-blue">12 files</span></td>
                        <td style="color:var(--tx-s);">2025</td>
                        <td><button class="btn-ico bi-view" title="View"><i class="fas fa-eye"></i></button></td>
                    </tr>
                    <tr>
                        <td><span class="t-code">CSE-0300</span></td>
                        <td><span class="t-name">Database Management System</span></td>
                        <td><span class="badge b-blue">8 files</span></td>
                        <td style="color:var(--tx-s);">2025</td>
                        <td><button class="btn-ico bi-view" title="View"><i class="fas fa-eye"></i></button></td>
                    </tr>
                    <tr>
                        <td><span class="t-code">CSE-0302</span></td>
                        <td><span class="t-name">Database Systems Lab</span></td>
                        <td><span class="badge b-blue">4 files</span></td>
                        <td style="color:var(--tx-s);">2025</td>
                        <td><button class="btn-ico bi-view" title="View"><i class="fas fa-eye"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/teacher/dashboard.blade.php ENDPATH**/ ?>