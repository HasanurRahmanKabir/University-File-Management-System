<aside class="sidebar" id="sidebar">
    <div class="sb-scroll">
        <div class="sb-brand" style="align-items: center;">
            <?php if(isset($globalSettings['student_logo']) && $globalSettings['student_logo']): ?>
                <div class="brand-logo" style="width: 55px; height: 55px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <img src="<?php echo e(asset('storage/' . $globalSettings['student_logo'])); ?>" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
            <?php else: ?>
                <div class="sb-logo brand-logo">
                    <i class="fas fa-user-graduate"></i>
                </div>
            <?php endif; ?>
            <div class="brand-text" style="flex: 1; min-width: 0;">
                <span class="sb-brand-name" style="word-wrap: break-word; white-space: normal;"><?php echo e($globalSettings['student_dashboard_name'] ?? 'StudentHub'); ?></span>
                <span class="sb-brand-tag" style="word-wrap: break-word; white-space: normal;"><?php echo e($globalSettings['brand_tagline'] ?? 'OBE Portal'); ?></span>
            </div>
            <i class="fas fa-bars sb-desktop-toggler" id="toggleBtn" style="cursor: pointer; align-self: flex-start; margin-top: 2px; color: var(--tx-m); font-size: 1.1rem; padding: 4px;"></i>
        </div>

        <nav class="sb-nav">
            <span class="sb-section-lbl">Overview</span>
            <ul>
                <li><a href="<?php echo e(route('student.dashboard')); ?>" class="sb-link <?php echo e(request()->routeIs('student.dashboard') ? 'active' : ''); ?>">
                    <div class="sb-ico"><i class="fas fa-th-large" title="Dashboard"></i></div><span class="sb-text">Dashboard</span>
                </a></li>
            </ul>
            <span class="sb-section-lbl">Academics</span>
            <ul>
                <li><a href="<?php echo e(route('student.courses.index')); ?>" class="sb-link <?php echo e(request()->routeIs('student.courses.*') ? 'active' : ''); ?>">
                    <div class="sb-ico"><i class="fas fa-book-open" title="Course Info"></i></div><span class="sb-text">Course Info</span>
                </a></li>
                <li><a href="<?php echo e(route('student.course-materials.index')); ?>" class="sb-link <?php echo e(request()->routeIs('student.course-materials.*') ? 'active' : ''); ?>">
                    <div class="sb-ico"><i class="fas fa-file-lines" title="Course File Info"></i></div><span class="sb-text">Course File Info</span>
                </a></li>
                <li><a href="<?php echo e(route('student.categories.index')); ?>" class="sb-link <?php echo e(request()->routeIs('student.categories.*') ? 'active' : ''); ?>">
                    <div class="sb-ico"><i class="fas fa-tags" title="Category List"></i></div><span class="sb-text">Category List</span>
                </a></li>
                <li><a href="<?php echo e(route('student.subcategories.index')); ?>" class="sb-link <?php echo e(request()->routeIs('student.subcategories.*') ? 'active' : ''); ?>">
                    <div class="sb-ico"><i class="fas fa-layer-group" title="Subcategory List"></i></div><span class="sb-text">Subcategory List</span>
                </a></li>
            </ul>
        </nav>
    </div>
    <div class="sb-footer">
        <form action="<?php echo e(route('logout')); ?>" method="POST" style="margin: 0; padding: 0; width: 100%;">
            <?php echo csrf_field(); ?>
            <button class="sb-logout" type="submit" style="width: 100%; border: none; justify-content: center;" title="Log Out">
                <div class="sb-ico" style="margin: 0;"><i class="fas fa-right-from-bracket"></i></div><span class="sb-text">Log Out</span>
            </button>
        </form>
    </div>
</aside>
<?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views\layouts\partials\student-sidebar.blade.php ENDPATH**/ ?>