<?php $__env->startSection('title', 'Subcategory List — StudentHub OBE'); ?>
<?php $__env->startSection('page-title', 'Subcategory List'); ?>
<?php $__env->startSection('breadcrumb', 'Subcategory List'); ?>

<?php $__env->startSection('content'); ?>

<?php $__empty_1 = true; $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php
    // Slight animation delay stagger
    $delay = 0.05 * ($index + 1);
    
    // Alternate icon colors based on index for visual flair
    $iconBg = $index % 2 == 0 ? '#f0fdf4' : '#eff6ff';
    $iconColor = $index % 2 == 0 ? '#059669' : '#2563eb';
    $badgeClass = $index % 2 == 0 ? 'b-green' : 'b-blue';
?>
<div class="d-card" style="animation-delay:<?php echo e($delay); ?>s; margin-bottom: 2rem;">
    <div class="d-card-header" style="flex-wrap: wrap;">
        <div class="d-card-title" style="flex: 1; min-width: 0; word-break: break-word;">
            <div class="d-card-ico" style="background:<?php echo e($iconBg); ?>;color:<?php echo e($iconColor); ?>; flex-shrink: 0;"><i class="fas fa-layer-group"></i></div>
            <span><?php echo e($subcategory->name); ?></span>
        </div>
        <span class="badge <?php echo e($badgeClass); ?>" style="white-space: nowrap;"><?php echo e($subcategory->courses->count()); ?> <?php echo e($subcategory->courses->count() == 1 ? 'Course' : 'Courses'); ?></span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl" style="width: 100%; min-width: 600px; text-align: center; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 10%; min-width: 80px;">#</th>
                        <th style="text-align: center; width: 15%; min-width: 120px;">Course Code</th>
                        <th style="text-align: center; width: 25%; min-width: 150px;">Course Name</th>
                        <th style="text-align: center; width: 35%; min-width: 250px;">Description</th>
                        <th style="text-align: center; width: 15%; min-width: 100px;">Credit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_2 = true; $__currentLoopData = $subcategory->courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cIndex => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                    <tr>
                        <td style="text-align: center; max-width: 80px;">
                            <span class="row-num"><?php echo e(str_pad($cIndex + 1, 2, '0', STR_PAD_LEFT)); ?></span>
                        </td>
                        <td style="text-align: center; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <span class="t-code"><?php echo e($course->course_code); ?></span>
                        </td>
                        <td style="text-align: center; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <span class="t-name" title="<?php echo e($course->title); ?>"><?php echo e($course->title); ?></span>
                        </td>
                        <td style="text-align: center; color:var(--tx-s); max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo e($course->description); ?>">
                            <span class="t-desc"><?php echo e(\Illuminate\Support\Str::limit($course->description ?? 'No description available', 40)); ?></span>
                        </td>
                        <td style="text-align: center; max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <span class="badge b-gray"><?php echo e($course->credit ?? 'N/A'); ?></span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px; color: var(--tx-s);">
                            <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; gap:10px;">
                                <i class="fas fa-folder-open" style="font-size:2rem; color:var(--b-color);"></i>
                                <span>No courses found in this subcategory.</span>
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
            <div class="empty-title">No Subcategories Found</div>
            <div class="empty-sub">You are not enrolled in any active courses with subcategories.</div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="mt-4">
    <?php echo e($subcategories->links('pagination::bootstrap-5')); ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views\student\subcategories\index.blade.php ENDPATH**/ ?>