<header class="topbar">
    <div>
        <div class="tb-title">@yield('page_title', 'Dashboard')</div>
        <div class="tb-breadcrumb">
            <a href="{{ route('teacher.dashboard') }}">Home</a>
            <span>/</span>
            <span>@yield('page_title', 'Dashboard')</span>
        </div>
    </div>
    <div class="tb-right">
        <div class="d-none d-sm-block" style="text-align:right;">
            <div class="tb-uname">{{ Auth::user()->name ?? 'Teacher Name' }}</div>
            <div class="tb-urole">{{ Auth::user()->designation ?? 'Teacher' }}</div>
        </div>
        @php
            $name = Auth::user()->name ?? 'Teacher Name';
            $words = array_filter(explode(' ', trim($name)));
            $initials = strtoupper(substr(array_shift($words), 0, 1));
            if (!empty($words)) {
                $initials .= strtoupper(substr(array_shift($words), 0, 1));
            }
        @endphp
        <div class="dropdown">
            <div class="tb-avatar" data-bs-toggle="dropdown" aria-expanded="false">{{ $initials }}</div>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border:1px solid var(--bd-lt); border-radius: var(--r-md); padding: 8px 0; min-width: 200px;">
                <li><a class="dropdown-item" href="{{ route('teacher.profile') }}" style="font-size: 0.85rem; padding: 8px 16px; color: var(--tx-h);"><i class="fas fa-user-circle" style="width:20px; color:var(--tx-m);"></i> My Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('teacher.settings') }}" style="font-size: 0.85rem; padding: 8px 16px; color: var(--tx-h);"><i class="fas fa-cog" style="width:20px; color:var(--tx-m);"></i> Account Settings</a></li>
                <li><hr class="dropdown-divider" style="border-color: var(--bd-lt); margin: 6px 0;"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item" style="font-size: 0.85rem; padding: 8px 16px; color: var(--danger);"><i class="fas fa-sign-out-alt" style="width:20px;"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
