<aside class="sidebar" id="sidebar">
    <div class="sb-scroll">
        <div class="sb-brand">
            @if(isset($globalSettings['student_logo']) && $globalSettings['student_logo'])
                <div style="width: 55px; height: 55px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <img src="{{ asset('storage/' . $globalSettings['student_logo']) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
            @else
                <div class="sb-logo">
                    <i class="fas fa-user-graduate"></i>
                </div>
            @endif
            <div>
                <span class="sb-brand-name">{{ $globalSettings['student_dashboard_name'] ?? 'StudentHub' }}</span>
                <span class="sb-brand-tag">{{ $globalSettings['brand_tagline'] ?? 'OBE Portal' }}</span>
            </div>
        </div>

        <nav class="sb-nav">
            <span class="sb-section-lbl">Overview</span>
            <ul>
                <li><a href="{{ route('student.dashboard') }}" class="sb-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <div class="sb-ico"><i class="fas fa-th-large"></i></div>Dashboard
                </a></li>
            </ul>
            <span class="sb-section-lbl">Academics</span>
            <ul>
                <li><a href="{{ route('student.courses.index') }}" class="sb-link {{ request()->routeIs('student.courses.*') ? 'active' : '' }}">
                    <div class="sb-ico"><i class="fas fa-book-open"></i></div>Course Info
                </a></li>
                <li><a href="{{ route('student.course-materials.index') }}" class="sb-link {{ request()->routeIs('student.course-materials.*') ? 'active' : '' }}">
                    <div class="sb-ico"><i class="fas fa-file-lines"></i></div>Course File Info
                </a></li>
                <li><a href="{{ route('student.categories.index') }}" class="sb-link {{ request()->routeIs('student.categories.*') ? 'active' : '' }}">
                    <div class="sb-ico"><i class="fas fa-tags"></i></div>Category List
                </a></li>
                <li><a href="{{ route('student.subcategories.index') }}" class="sb-link {{ request()->routeIs('student.subcategories.*') ? 'active' : '' }}">
                    <div class="sb-ico"><i class="fas fa-layer-group"></i></div>Subcategory List
                </a></li>
            </ul>
        </nav>
    </div>
    <div class="sb-footer">
        <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
            @csrf
            <button class="sb-logout" type="submit" style="width: 100%; border: none;">
                <div class="sb-ico"><i class="fas fa-right-from-bracket"></i></div>Log Out
            </button>
        </form>
    </div>
</aside>
