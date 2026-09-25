<?php $__env->startSection('title', 'Subcategory List — TeacherHub OBE'); ?>
<?php $__env->startSection('page_title', 'Subcategory List'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div class="heading-group">
        <h2 class="mb-1" style="font-size: 1.5rem; font-weight: 700; color: var(--text-heading); letter-spacing: -0.5px;">Course Subcategories</h2>
        <p class="text-muted m-0" style="font-size: 0.85rem;">Your assigned courses grouped by subcategories.</p>
    </div>
</div>

<?php $__empty_1 = true; $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php
    $delay = 0.05 * ($index + 1);
    $colors = [
        ['bg' => 'var(--success-lt)', 'text' => 'var(--success)', 'icon' => 'fa-code-branch', 'badge' => 'b-green'],
        ['bg' => 'var(--purple-lt)', 'text' => 'var(--purple)', 'icon' => 'fa-sitemap', 'badge' => 'b-purple'],
        ['bg' => 'var(--info-lt)', 'text' => 'var(--info)', 'icon' => 'fa-layer-group', 'badge' => 'b-blue'],
        ['bg' => 'var(--warning-lt)', 'text' => 'var(--warning)', 'icon' => 'fa-hashtag', 'badge' => 'b-orange'],
    ];
    $style = $colors[$index % count($colors)];
?>
<div class="d-card mb-4" style="animation-delay:<?php echo e($delay); ?>s">
    <div class="d-card-header" style="background: #f8fafc; border-bottom: 1px solid var(--border-light); padding: 12px 20px;">
        <div class="d-card-title" style="font-size: 1.1rem; color: var(--text-heading);">
            <div class="d-card-ico" style="background:<?php echo e($style['bg']); ?>;color:<?php echo e($style['text']); ?>; width: 32px; height: 32px; border-radius: 6px;"><i class="fas <?php echo e($style['icon']); ?>" style="font-size: 0.9rem;"></i></div>
            <?php echo e($subcategory->name); ?>

        </div>
        <span class="badge <?php echo e($style['badge']); ?>" style="padding:5px 12px; font-weight: 600;"><?php echo e($subcategory->courses->count()); ?> <?php echo e(Str::plural('Course', $subcategory->courses->count())); ?></span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl" style="min-width: 800px;">
                <thead>
                    <tr>
                        <th class="text-start" style="width: 25%; min-width: 90px;">Course Code</th>
                        <th class="text-center" style="width: 25%;">Course Title</th>
                        <th class="text-center" style="width: 25%;">Course Credit</th>
                        <th class="text-end" style="width: 25%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_2 = true; $__currentLoopData = $subcategory->courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                    <tr>
                        <td class="text-start" style="white-space: nowrap;"><span class="t-code"><?php echo e($course->course_code); ?></span></td>
                        <td class="text-center"><span class="t-name"><?php echo e($course->title); ?></span></td>
                        <td class="text-center"><span class="badge b-gray"><?php echo e($course->credit ?? 'N/A'); ?></span></td>
                        <td class="text-end">
                            <?php if($course->is_active): ?>
                                <span class="badge b-green"><i class="fas fa-check-circle" style="margin-right:4px;"></i>Active</span>
                            <?php else: ?>
                                <span class="badge b-gray"><i class="fas fa-times-circle" style="margin-right:4px;"></i>Inactive</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                    <tr>
                        <td colspan="4">
                            <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding: 40px 20px; text-align: center;">
                                <div class="empty-ico" style="font-size: 2.5rem; color: var(--bd-dark, #cbd5e1); margin-bottom: 15px;"><i class="fas fa-folder-open"></i></div>
                                <h6 style="color: var(--tx-h); font-weight: 600; margin-bottom: 5px;">No Courses</h6>
                                <p style="color: var(--tx-m); font-size: 0.85rem; max-width: 400px; margin: 0 auto;">No courses found in this subcategory.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<div class="d-card" style="animation-delay:.12s">
    <div class="d-card-body">
        <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding: 40px 20px; text-align: center;">
            <div class="empty-ico" style="font-size: 3rem; color: var(--bd-dark, #cbd5e1); margin-bottom: 15px;"><i class="fas fa-layer-group"></i></div>
            <h5 style="color: var(--tx-h); font-weight: 600; margin-bottom: 5px;">No Subcategories Available</h5>
            <p style="color: var(--tx-m); font-size: 0.9rem; max-width: 400px; margin: 0 auto;">There are currently no course subcategories assigned to your courses.</p>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if($subcategories->hasPages()): ?>
<div style="padding: 15px 20px; display:flex; justify-content:flex-end;">
    <?php echo e($subcategories->links('pagination::bootstrap-5')); ?>

</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/teacher/subcategorylist.blade.php ENDPATH**/ ?>