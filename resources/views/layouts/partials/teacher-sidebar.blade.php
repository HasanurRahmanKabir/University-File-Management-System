<aside class="sidebar" id="sidebar">
    <div class="sb-scroll">
        <div class="sb-brand">
            <div class="sb-logo"><i class="fas fa-chalkboard-teacher"></i></div>
            <div>
                <span class="sb-brand-name">TeacherHub</span>
                <span class="sb-brand-tag">OBE Portal</span>
            </div>
        </div>
        <nav class="sb-nav">
            <span class="sb-lbl">Overview</span>
            <ul>
                <li><a href="{{ route('teacher.dashboard') }}" class="sb-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}"><div class="sb-ico"><i class="fas fa-th-large"></i></div>Dashboard</a></li>
            </ul>
            <span class="sb-lbl">Academics</span>
            <ul>
                <li><a href="{{ route('teacher.courses.index') }}" class="sb-link {{ request()->routeIs('teacher.courses.*') ? 'active' : '' }}"><div class="sb-ico"><i class="fas fa-book-open"></i></div>My Course Info</a></li>
                <li><a href="{{ route('teacher.course-materials.index') }}" class="sb-link {{ request()->routeIs('teacher.course-materials.*') ? 'active' : '' }}"><div class="sb-ico"><i class="fas fa-cloud-arrow-up"></i></div>Upload Materials</a></li>
                <li><a href="#" class="sb-link"><div class="sb-ico"><i class="fas fa-tags"></i></div>Category List</a></li>
                <li><a href="#" class="sb-link"><div class="sb-ico"><i class="fas fa-layer-group"></i></div>Subcategory List</a></li>
            </ul>
        </nav>
    </div>
    <div class="sb-footer">
        <form action="{{ route('logout') }}" method="POST" style="margin: 0; width: 100%;">
            @csrf
            <button class="sb-logout" type="submit" style="justify-content: center; color: #94a3b8;">
                <i class="fas fa-arrow-right-from-bracket" style="margin-right: 8px;"></i> Log Out
            </button>
        </form>
    </div>
</aside>
