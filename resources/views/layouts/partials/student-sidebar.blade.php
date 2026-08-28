<aside class="sidebar" id="sidebar">
    <div class="sb-scroll">
        <div class="sb-brand" style="align-items: center;">
            @if(isset($globalSettings['student_logo']) && $globalSettings['student_logo'])
                <div class="brand-logo" style="width: 55px; height: 55px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <img src="{{ asset('storage/' . $globalSettings['student_logo']) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
            @else
                <div class="sb-logo brand-logo">
                    <i class="fas fa-user-graduate"></i>
                </div>
            @endif
            <div class="brand-text" style="flex: 1; min-width: 0;">
                <span class="sb-brand-name" style="word-wrap: break-word; white-space: normal;">{{ $globalSettings['student_dashboard_name'] ?? 'StudentHub' }}</span>
                <span class="sb-brand-tag" style="word-wrap: break-word; white-space: normal;">{{ $globalSettings['brand_tagline'] ?? 'OBE Portal' }}</span>
            </div>
            <i class="fas fa-bars sb-desktop-toggler" id="toggleBtn" style="cursor: pointer; align-self: flex-start; margin-top: 2px; color: var(--tx-m); font-size: 1.1rem; padding: 4px;"></i>
        </div>

        <nav class="sb-nav">
            <span class="sb-section-lbl">Overview</span>
            <ul>
                <li><a href="{{ route('student.dashboard') }}" class="sb-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <div class="sb-ico"><i class="fas fa-th-large" title="Dashboard"></i></div><span class="sb-text">Dashboard</span>
                </a></li>
            </ul>
            <span class="sb-section-lbl">Academics</span>
            <ul>
                <li><a href="{{ route('student.courses.index') }}" class="sb-link {{ request()->routeIs('student.courses.*') ? 'active' : '' }}">
                    <div class="sb-ico"><i class="fas fa-book-open" title="Course Info"></i></div><span class="sb-text">Course Info</span>
                </a></li>
                <li><a href="{{ route('student.course-materials.index') }}" class="sb-link {{ request()->routeIs('student.course-materials.*') ? 'active' : '' }}">
                    <div class="sb-ico"><i class="fas fa-file-lines" title="Course File Info"></i></div><span class="sb-text">Course File Info</span>
                </a></li>
                <li><a href="{{ route('student.categories.index') }}" class="sb-link {{ request()->routeIs('student.categories.*') ? 'active' : '' }}">
                    <div class="sb-ico"><i class="fas fa-tags" title="Category List"></i></div><span class="sb-text">Category List</span>
                </a></li>
                <li><a href="{{ route('student.subcategories.index') }}" class="sb-link {{ request()->routeIs('student.subcategories.*') ? 'active' : '' }}">
                    <div class="sb-ico"><i class="fas fa-layer-group" title="Subcategory List"></i></div><span class="sb-text">Subcategory List</span>
                </a></li>
            </ul>
        </nav>
    </div>
    <div class="sb-footer">
        <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0; width: 100%;">
            @csrf
            <button class="sb-logout" type="submit" style="width: 100%; border: none; justify-content: center;" title="Log Out">
                <div class="sb-ico" style="margin: 0;"><i class="fas fa-right-from-bracket"></i></div><span class="sb-text">Log Out</span>
            </button>
        </form>
    </div>
</aside>
