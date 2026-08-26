<?php $__env->startSection('title', 'Category List — TeacherHub OBE'); ?>
<?php $__env->startSection('page_title', 'Category List'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-hero">
    <div><div class="p-hero-h">Course Categories</div><div class="p-hero-sub">Browse and view major course categories</div></div>
</div>

<div class="d-card" style="animation-delay:.05s">
    <div class="d-card-header">
        <div class="d-card-title"><div class="d-card-ico"><i class="fas fa-tags"></i></div>Major Categories</div>
        <span class="badge b-green" style="padding:5px 12px;"><?php echo e(str_pad($categories->total(), 2, '0', STR_PAD_LEFT)); ?> categories</span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl">
                <thead>
                    <tr><th style="text-align:center; width: 60px;">#</th><th style="text-align:center;">Category Name</th><th style="text-align:center;">Courses</th><th style="text-align:center;">Description</th></tr>
                </thead>
                <tbody>
                    <?php
                        $colors = [
                            ['bg' => 'var(--success-lt)', 'text' => 'var(--success)', 'icon' => 'fa-code-branch'],
                            ['bg' => 'var(--purple-lt)', 'text' => 'var(--purple)', 'icon' => 'fa-sitemap'],
                            ['bg' => 'var(--info-lt)', 'text' => 'var(--info)', 'icon' => 'fa-layer-group'],
                            ['bg' => 'var(--warning-lt)', 'text' => 'var(--warning)', 'icon' => 'fa-hashtag'],
                        ];
                    ?>
                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php $style = $colors[$index % count($colors)]; ?>
                        <tr>
                            <td style="text-align:center;"><span class="t-num"><?php echo e(str_pad($categories->firstItem() + $index, 2, '0', STR_PAD_LEFT)); ?></span></td>
                            <td style="text-align:center;">
                                <div style="display:flex;align-items:center;text-align:left;width:200px;margin:0 auto;gap:10px;">
                                    <div class="cat-ico" style="width:34px;height:34px;background:<?php echo e($style['bg']); ?>;color:<?php echo e($style['text']); ?>;flex-shrink:0;">
                                        <i class="fas <?php echo e($style['icon']); ?>" style="font-size:.76rem;"></i>
                                    </div>
                                    <span class="t-name" style="word-break:break-word;line-height:1.3;"><?php echo e($category->name); ?></span>
                                </div>
                            </td>
                            <td style="text-align:center;"><span class="badge b-blue"><?php echo e(str_pad($category->courses_count, 2, '0', STR_PAD_LEFT)); ?> Courses</span></td>
                            <td style="text-align:center; color:var(--tx-s); font-size:.80rem;"><?php echo e($category->description ?? 'No description available.'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4">
                                <div class="empty-state" style="padding: 60px 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                                    <div class="empty-ico" style="font-size: 3.5rem; color: var(--bd); margin-bottom: 20px;"><i class="fas fa-tags"></i></div>
                                    <h5 style="color: var(--tx-h); font-weight: 700; margin-bottom: 8px; font-size: 1.1rem;">No Categories Available</h5>
                                    <p style="color: var(--tx-m); font-size: 0.9rem; max-width: 450px; margin: 0 auto; line-height: 1.5;">There are currently no course categories assigned or available in the system.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if($categories->hasPages()): ?>
<div style="padding: 15px 20px; display:flex; justify-content:flex-end;">
    <?php echo e($categories->links('pagination::bootstrap-5')); ?>

</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/teacher/categorylist.blade.php ENDPATH**/ ?>