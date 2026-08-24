<?php $__env->startSection('title', 'Subcategory List — TeacherHub OBE'); ?>
<?php $__env->startSection('page_title', 'Subcategory List'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-hero">
    <div><div class="p-hero-h">Subcategory (Course) List</div><div class="p-hero-sub">Subcategories mapped to major categories and course codes</div></div>
</div>

<div class="d-card" style="animation-delay:.05s">
    <div class="d-card-header">
        <div class="d-card-title"><div class="d-card-ico"><i class="fas fa-layer-group"></i></div>Subcategories Under Major Categories</div>
        <span class="badge b-green" style="padding:5px 12px;"><?php echo e(str_pad($subcategories->total(), 2, '0', STR_PAD_LEFT)); ?> records</span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl">
                <thead>
                    <tr>
                        <th style="text-align:center; width: 60px;">#</th>
                        <th style="text-align:center;">Subcategory Name</th>
                        <th style="text-align:center;">Parent Category</th>
                        <th style="text-align:center;">Status</th>
                    </tr>
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
                    <?php $__empty_1 = true; $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php $style = $colors[$index % count($colors)]; ?>
                        <tr>
                            <td style="text-align:center;"><span class="t-num"><?php echo e(str_pad($subcategories->firstItem() + $index, 2, '0', STR_PAD_LEFT)); ?></span></td>
                            <td style="text-align:center;">
                                <div style="display:flex;align-items:center;justify-content:center;gap:9px;">
                                    <div style="width:7px;height:7px;border-radius:50%;background:<?php echo e($style['text']); ?>;box-shadow:0 0 0 2px <?php echo e($style['bg']); ?>;flex-shrink:0;"></div>
                                    <span class="t-name"><?php echo e($subcategory->name); ?></span>
                                </div>
                            </td>
                            <td style="text-align:center;">
                                <div style="display:flex;align-items:center;justify-content:center;gap:7px;">
                                    <div class="cat-ico" style="width:24px;height:24px;background:<?php echo e($style['bg']); ?>;color:<?php echo e($style['text']); ?>;font-size:.60rem;"><i class="fas <?php echo e($style['icon']); ?>"></i></div>
                                    <span class="badge b-gray"><?php echo e($subcategory->category ? $subcategory->category->name : 'N/A'); ?></span>
                                </div>
                            </td>
                            <td style="text-align:center;">
                                <?php if($subcategory->is_active): ?>
                                    <span class="badge b-green"><i class="fas fa-check" style="margin-right:4px;"></i>Active</span>
                                <?php else: ?>
                                    <span class="badge b-gray" style="color:var(--tx-m);"><i class="fas fa-ban" style="margin-right:4px;"></i>Inactive</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4">
                                <div class="empty-state" style="padding: 60px 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                                    <div class="empty-ico" style="font-size: 3.5rem; color: var(--bd); margin-bottom: 20px;"><i class="fas fa-layer-group"></i></div>
                                    <h5 style="color: var(--tx-h); font-weight: 700; margin-bottom: 8px; font-size: 1.1rem;">No Subcategories Available</h5>
                                    <p style="color: var(--tx-m); font-size: 0.9rem; max-width: 450px; margin: 0 auto; line-height: 1.5;">There are currently no subcategories assigned or available in the system.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if($subcategories->hasPages()): ?>
<div style="padding: 15px 20px; display:flex; justify-content:flex-end;">
    <?php echo e($subcategories->links('pagination::bootstrap-5')); ?>

</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views\teacher\subcategorylist.blade.php ENDPATH**/ ?>