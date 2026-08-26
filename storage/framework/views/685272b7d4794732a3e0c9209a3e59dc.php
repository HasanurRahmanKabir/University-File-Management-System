<?php $__env->startSection('title', 'Dashboard — StudentHub OBE'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('breadcrumb', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero -->
<div class="hero-banner">
    <div class="hero-inner">
        <div>
            <div class="hero-eyebrow"><i class="fas fa-circle" style="font-size:.4rem;color:#22c55e;"></i> Active Session</div>
            <div class="hero-greeting">Welcome back, <span><?php echo e(Auth::user()->name ?? 'Student'); ?></span> 👋</div>
            <div class="hero-sub">Here's an overview of your academic progress for today.</div>
        </div>
        <div class="hero-right">
            <div class="hero-pill"><i class="fas fa-calendar-check"></i> Semester: <?php echo e(Auth::user()->semester ?? 'Not Assigned'); ?></div>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card sc-blue" style="animation-delay:.05s">
        <div class="stat-header">
            <div class="stat-lbl">Enrolled Courses</div>
            <div class="stat-ico ico-blue"><i class="fas fa-book-open"></i></div>
        </div>
        <div class="stat-val" data-count="<?php echo e($stats['courses']); ?>"><?php echo e(str_pad($stats['courses'], 2, '0', STR_PAD_LEFT)); ?></div>
        <div class="stat-sub"><?php echo e(Auth::user()->semester ?? 'Current'); ?> Semester</div>
    </div>
    <div class="stat-card sc-green" style="animation-delay:.10s">
        <div class="stat-header">
            <div class="stat-lbl">New Files Uploaded</div>
            <div class="stat-ico ico-green"><i class="fas fa-file-arrow-up"></i></div>
        </div>
        <div class="stat-val" data-count="<?php echo e($stats['materials']); ?>"><?php echo e(str_pad($stats['materials'], 2, '0', STR_PAD_LEFT)); ?></div>
        <div class="stat-sub">By your teachers</div>
    </div>
    <div class="stat-card sc-orange" style="animation-delay:.15s">
        <div class="stat-header">
            <div class="stat-lbl">Pending Assignments</div>
            <div class="stat-ico ico-orange"><i class="fas fa-clipboard-list"></i></div>
        </div>
        <div class="stat-val" data-count="<?php echo e($stats['assignments']); ?>"><?php echo e(str_pad($stats['assignments'], 2, '0', STR_PAD_LEFT)); ?></div>
        <div class="stat-sub">Due this week</div>
    </div>
</div>

<!-- Course Table -->
<div class="d-card" style="animation-delay:.20s">
    <div class="d-card-header">
        <div class="d-card-title">
            <div class="d-card-ico" style="background:#eff6ff;color:#2563eb;"><i class="fas fa-graduation-cap"></i></div>
            My Course Information
        </div>
        <style>
            .btn-view-all {
                font-size: .75rem;
                background: #eff6ff;
                color: #2563eb;
                padding: 5px 12px;
                border-radius: 6px;
                font-weight: 600;
                text-decoration: none;
                border: 1px solid #bfdbfe;
                transition: all 0.2s ease;
            }
            .btn-view-all:hover {
                background: #ffffff;
                color: #2563eb;
                border-color: #2563eb;
                box-shadow: 0 2px 8px rgba(37,99,235,0.15);
            }
        </style>
        <a href="<?php echo e(route('student.courses.index')); ?>" class="btn-ghost btn-view-all">
            View All <i class="fas fa-arrow-right" style="font-size:.65rem; margin-left: 3px;"></i>
        </a>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl" style="width: 100%; min-width: 700px; text-align: center; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 20%; min-width: 140px;">Course Code</th>
                        <th style="text-align: center; width: 20%; min-width: 140px;">Course Title</th>
                        <th style="text-align: center; width: 20%; min-width: 140px;">Instructor</th>
                        <th style="text-align: center; width: 20%; min-width: 140px;">Year</th>
                        <th style="text-align: center; width: 20%; min-width: 140px;">Semester</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $recentCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="text-align: center; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><span class="t-code"><?php echo e($course->course_code); ?></span></td>
                        <td style="text-align: center; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><span class="t-name"><?php echo e($course->title ?? $course->course_name ?? 'Course'); ?></span></td>
                        <td style="text-align: center; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color:var(--tx-s);"><?php echo e(optional($course->teacher)->name ?? 'TBA'); ?></td>
                        <td style="text-align: center; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color:var(--tx-s);"><?php echo e(optional($course->created_at)->format('Y') ?? 'N/A'); ?></td>
                        <td style="text-align: center; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><span class="badge b-blue"><?php echo e(Auth::user()->semester ?? 'Current Semester'); ?></span></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" style="padding: 0; border-bottom: none;">
                            <div class="empty-state">
                                <div class="empty-ico"><i class="fas fa-folder-open"></i></div>
                                <div class="empty-title">No Courses Enrolled</div>
                                <div class="empty-sub">You are not enrolled in any courses for the current semester. Please contact your department if this is a mistake.</div>
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

<?php $__env->startPush('scripts'); ?>
<script>
    // Animated counters
    document.querySelectorAll('.stat-val[data-count]').forEach(el=>{
        const target=parseInt(el.dataset.count), dur=900;
        if(target === 0) return;
        const obs=new IntersectionObserver(ents=>{
            if(!ents[0].isIntersecting) return; obs.disconnect();
            let start=null;
            const step=ts=>{
                if(!start) start=ts;
                const pct=Math.min((ts-start)/dur, 1);
                const ease=1-Math.pow(1-pct,3);
                el.textContent=Math.round(ease*target).toString().padStart(2,'0');
                if(pct<1) requestAnimationFrame(step);
            };
            requestAnimationFrame(step);
        },{threshold:.5});
        obs.observe(el);
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/student/dashboard.blade.php ENDPATH**/ ?>