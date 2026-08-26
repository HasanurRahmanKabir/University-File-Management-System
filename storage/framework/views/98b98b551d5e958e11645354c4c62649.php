<?php $__env->startSection('title', 'Course File Info — StudentHub OBE'); ?>
<?php $__env->startSection('page-title', 'Course File Info'); ?>
<?php $__env->startSection('breadcrumb', 'Course File Info'); ?>

<?php $__env->startSection('content'); ?>

<?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php
    // Slight animation delay stagger
    $delay = 0.05 * ($index + 1);
    
    // Alternate icon colors based on index for visual flair
    $iconBg = $index % 2 == 0 ? '#eff6ff' : '#f0fdf4';
    $iconColor = $index % 2 == 0 ? '#2563eb' : '#059669';
    $badgeClass = $index % 2 == 0 ? 'b-blue' : 'b-green';
?>
<div class="d-card" style="animation-delay:<?php echo e($delay); ?>s; margin-bottom: 2rem;">
    <div class="d-card-header" style="flex-wrap: wrap;">
        <div class="d-card-title" style="flex: 1; min-width: 0; word-break: break-word;">
            <div class="d-card-ico" style="background:<?php echo e($iconBg); ?>;color:<?php echo e($iconColor); ?>; flex-shrink: 0;"><i class="fas fa-folder-open"></i></div>
            <span><?php echo e($course->course_code ?? 'Course'); ?> <span style="color:var(--tx-s);font-weight:400;">— <?php echo e($course->title ?? 'N/A'); ?></span></span>
        </div>
        <span class="badge <?php echo e($badgeClass); ?>" style="white-space: nowrap;"><i class="fas fa-calendar" style="font-size:.55rem;"></i> <?php echo e(Auth::user()->semester ?? 'Current Semester'); ?></span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl" style="width: 100%; min-width: 600px; text-align: center; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 25%; min-width: 150px;">File Type</th>
                        <th style="text-align: center; width: 25%; min-width: 150px;">File Description</th>
                        <th style="text-align: center; width: 25%; min-width: 150px;">Size</th>
                        <th style="text-align: center; width: 25%; min-width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_2 = true; $__currentLoopData = $course->materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                    <?php
                        $size = $material->file_size;
                        $formattedSize = $size >= 1048576 ? round($size / 1048576, 2) . ' MB' : round($size / 1024, 2) . ' KB';
                        
                        $type = strtolower($material->file_type ?? 'file');
                        $typeBadge = 'b-gray';
                        $icon = 'fa-file';
                        if(str_contains($type, 'pdf')) { $typeBadge = 'b-red'; $icon = 'fa-file-pdf'; }
                        elseif(str_contains($type, 'doc') || str_contains($type, 'word')) { $typeBadge = 'b-blue'; $icon = 'fa-file-word'; }
                        elseif(str_contains($type, 'ppt') || str_contains($type, 'powerpoint')) { $typeBadge = 'b-yellow'; $icon = 'fa-file-powerpoint'; }
                        elseif(str_contains($type, 'xls') || str_contains($type, 'excel')) { $typeBadge = 'b-green'; $icon = 'fa-file-excel'; }
                        elseif(str_contains($type, 'zip') || str_contains($type, 'rar')) { $typeBadge = 'b-purple'; $icon = 'fa-file-zipper'; }
                        elseif(str_contains($type, 'image') || str_contains($type, 'png') || str_contains($type, 'jpg')) { $typeBadge = 'b-teal'; $icon = 'fa-file-image'; }
                        elseif(str_contains($type, 'video') || str_contains($type, 'mp4')) { $typeBadge = 'b-red'; $icon = 'fa-file-video'; }
                    ?>
                    <tr>
                        <td style="text-align: center; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <span class="badge <?php echo e($typeBadge); ?>"><i class="fas <?php echo e($icon); ?>"></i> <?php echo e(strtoupper($material->file_type ?? 'FILE')); ?></span>
                        </td>
                        <td style="text-align: center; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <span class="t-name" title="<?php echo e($material->title); ?>"><?php echo e($material->title); ?></span>
                        </td>
                        <td style="text-align: center; color:var(--tx-s); max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <?php echo e($size ? $formattedSize : 'Unknown'); ?>

                        </td>
                        <td style="text-align: center;">
                            <?php if($material->file_path): ?>
                            <a href="<?php echo e(route('student.course-materials.download', $material->id)); ?>" class="act-link"><i class="fas fa-download"></i> Download</a>
                            <?php else: ?>
                            <span class="badge b-gray">No File</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px; color: var(--tx-s);">
                            <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; gap:10px;">
                                <i class="fas fa-folder-open" style="font-size:2rem; color:var(--b-color);"></i>
                                <span>No materials have been uploaded for this course yet.</span>
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
            <div class="empty-title">No Courses Enrolled</div>
            <div class="empty-sub">You are not enrolled in any courses, so there are no materials to display. Please contact your department if this is a mistake.</div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="mt-4">
    <?php echo e($courses->links('pagination::bootstrap-5')); ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/student/course-materials/index.blade.php ENDPATH**/ ?>