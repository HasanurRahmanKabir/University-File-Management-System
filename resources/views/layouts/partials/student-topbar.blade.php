<header class="topbar">
    <div class="tb-left">
        <div class="tb-title">@yield('page-title', 'Dashboard')</div>
        <div class="tb-breadcrumb">
            <span><a href="{{ route('student.dashboard') }}">Home</a></span>
            <span><i class="fas fa-chevron-right" style="font-size:.5rem;color:#d1d5db;"></i></span>
            <span>@yield('breadcrumb', 'Dashboard')</span>
        </div>
    </div>
    <div class="tb-right">
        <div class="tb-user-info d-none d-sm-block" style="text-align:right;">
            <div class="tb-uname">{{ Auth::user()->name ?? 'Student' }}</div>
            <div class="tb-urole">Student</div>
        </div>
        @php
            $name = Auth::user()->name ?? 'Student';
            $words = array_filter(explode(' ', trim($name)));
            $initials = strtoupper(substr(array_shift($words), 0, 1));
            if (!empty($words)) {
                $initials .= strtoupper(substr(array_shift($words), 0, 1));
            }
        @endphp
        <div class="dropdown" style="display: flex; align-items: center;">
            <div class="tb-avatar" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 1rem; overflow: hidden; width: 40px; height: 40px; border-radius: 50%;">
                @if(Auth::user()->profile_image)
                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    {{ $initials }}
                @endif
            </div>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border:1px solid var(--bd-lt); border-radius: var(--r-md); padding: 8px 0; min-width: 200px;">
                <li><a class="dropdown-item" href="{{ route('student.profile') }}" style="font-size: 0.85rem; padding: 8px 16px; color: var(--tx-h);"><i class="fas fa-user-circle" style="width:20px; color:var(--tx-m);"></i> My Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('student.settings') }}" style="font-size: 0.85rem; padding: 8px 16px; color: var(--tx-h);"><i class="fas fa-cog" style="width:20px; color:var(--tx-m);"></i> Account Settings</a></li>
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
