<aside class="sidebar" id="sidebar">
    <div class="sb-scroll">
        <div class="sb-brand" style="align-items: center;">
            <?php if(isset($globalSettings['teacher_logo']) && $globalSettings['teacher_logo']): ?>
                <div class="brand-logo" style="width: 55px; height: 55px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <img src="<?php echo e(asset('storage/' . $globalSettings['teacher_logo'])); ?>" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
            <?php else: ?>
                <div class="sb-logo brand-logo">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            <?php endif; ?>
            <div class="brand-text" style="flex: 1; min-width: 0;">
                <span class="sb-brand-name" style="word-wrap: break-word; white-space: normal;"><?php echo e($globalSettings['teacher_dashboard_name'] ?? 'TeacherHub'); ?></span>
                <span class="sb-brand-tag" style="word-wrap: break-word; white-space: normal;"><?php echo e($globalSettings['brand_tagline'] ?? 'OBE Portal'); ?></span>
            </div>
            <i class="fas fa-bars sb-desktop-toggler" id="toggleBtn" style="cursor: pointer; align-self: flex-start; margin-top: 2px; color: var(--tx-m); font-size: 1.1rem; padding: 4px;"></i>
        </div>
        <nav class="sb-nav">
            <span class="sb-lbl">Overview</span>
            <ul>
                <li><a href="<?php echo e(route('teacher.dashboard')); ?>" class="sb-link <?php echo e(request()->routeIs('teacher.dashboard') ? 'active' : ''); ?>"><div class="sb-ico"><i class="fas fa-th-large" title="Dashboard"></i></div><span class="sb-text">Dashboard</span></a></li>
            </ul>
            <span class="sb-lbl">Academics</span>
            <ul>
                <li><a href="<?php echo e(route('teacher.courses.index')); ?>" class="sb-link <?php echo e(request()->routeIs('teacher.courses.*') ? 'active' : ''); ?>"><div class="sb-ico"><i class="fas fa-book-open" title="My Course Info"></i></div><span class="sb-text">My Course Info</span></a></li>
                <li><a href="<?php echo e(route('teacher.course-materials.index')); ?>" class="sb-link <?php echo e(request()->routeIs('teacher.course-materials.*') ? 'active' : ''); ?>"><div class="sb-ico"><i class="fas fa-cloud-arrow-up" title="Upload Materials"></i></div><span class="sb-text">Upload Materials</span></a></li>
                <li><a href="<?php echo e(route('teacher.categories.index')); ?>" class="sb-link <?php echo e(request()->routeIs('teacher.categories.*') ? 'active' : ''); ?>"><div class="sb-ico"><i class="fas fa-tags" title="Category List"></i></div><span class="sb-text">Category List</span></a></li>
                <li><a href="<?php echo e(route('teacher.subcategories.index')); ?>" class="sb-link <?php echo e(request()->routeIs('teacher.subcategories.*') ? 'active' : ''); ?>"><div class="sb-ico"><i class="fas fa-layer-group" title="Subcategory List"></i></div><span class="sb-text">Subcategory List</span></a></li>
            </ul>
        </nav>
    </div>
    <div class="sb-footer">
        <form action="<?php echo e(route('logout')); ?>" method="POST" style="margin: 0; width: 100%;">
            <?php echo csrf_field(); ?>
            <button class="sb-logout" type="submit" style="justify-content: center; color: #94a3b8;" title="Log Out">
                <i class="fas fa-arrow-right-from-bracket" style="margin-right: 8px;"></i> <span class="sb-text">Log Out</span>
            </button>
        </form>
    </div>
</aside>
<?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views\layouts\partials\teacher-sidebar.blade.php ENDPATH**/ ?>