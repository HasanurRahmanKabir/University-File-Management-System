<?php $__env->startSection('title', 'Category List — StudentHub OBE'); ?>
<?php $__env->startSection('page-title', 'Category List'); ?>
<?php $__env->startSection('breadcrumb', 'Category List'); ?>

<?php $__env->startSection('content'); ?>

<?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php
    // Slight animation delay stagger
    $delay = 0.05 * ($index + 1);
    
    // Alternate icon colors based on index for visual flair
    $iconBg = $index % 2 == 0 ? '#eff6ff' : '#fffbeb';
    $iconColor = $index % 2 == 0 ? '#2563eb' : '#b45309';
    $badgeClass = $index % 2 == 0 ? 'b-blue' : 'b-yellow';
    $icon = $index % 2 == 0 ? 'fa-code' : 'fa-bolt';
?>
<div class="d-card" style="animation-delay:<?php echo e($delay); ?>s; margin-bottom: 2rem;">
    <div class="d-card-header" style="flex-wrap: wrap;">
        <div class="d-card-title" style="flex: 1; min-width: 0; word-break: break-word;">
            <div class="d-card-ico" style="background:<?php echo e($iconBg); ?>;color:<?php echo e($iconColor); ?>; flex-shrink: 0;"><i class="fas <?php echo e($icon); ?>"></i></div>
            <span><?php echo e($category->name); ?></span>
        </div>
        <span class="badge <?php echo e($badgeClass); ?>" style="white-space: nowrap;"><?php echo e($category->courses->count()); ?> <?php echo e($category->courses->count() == 1 ? 'Course' : 'Courses'); ?></span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl" style="width: 100%; min-width: 600px; text-align: center; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 10%; min-width: 80px;">#</th>
                        <th style="text-align: center; width: 30%; min-width: 150px;">Course Name</th>
                        <th style="text-align: center; width: 30%; min-width: 150px;">Instructor</th>
                        <th style="text-align: center; width: 30%; min-width: 150px;">Course Credit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_2 = true; $__currentLoopData = $category->courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cIndex => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                    <tr>
                        <td style="text-align: center; max-width: 80px;">
                            <span class="row-num"><?php echo e(str_pad($cIndex + 1, 2, '0', STR_PAD_LEFT)); ?></span>
                        </td>
                        <td style="text-align: center; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <span class="t-name" title="<?php echo e($course->title); ?>"><?php echo e($course->title); ?></span>
                        </td>
                        <td style="text-align: center; color:var(--tx-s); max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <?php echo e(optional($course->teacher)->name ?? 'TBA'); ?>

                        </td>
                        <td style="text-align: center; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <span class="badge b-gray"><?php echo e($course->credit ?? 'N/A'); ?></span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px; color: var(--tx-s);">
                            <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; gap:10px;">
                                <i class="fas fa-folder-open" style="font-size:2rem; color:var(--b-color);"></i>
                                <span>No courses found in this category.</span>
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
<div class="d-card">
    <div class="d-card-body" style="text-align: center; padding: 40px;">
        <div class="empty-state">
            <div class="empty-ico"><i class="fas fa-box-open"></i></div>
            <div class="empty-title">No Categories Found</div>
            <div class="empty-sub">You are not enrolled in any active category courses.</div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="mt-4">
    <?php echo e($categories->links('pagination::bootstrap-5')); ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/student/categories/index.blade.php ENDPATH**/ ?>