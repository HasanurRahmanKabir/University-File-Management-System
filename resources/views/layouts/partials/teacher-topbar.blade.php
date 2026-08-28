<header class="topbar">
    <div style="display: flex; align-items: center; gap: 12px;">
        <button class="sb-desktop-toggler d-lg-none" id="mobileToggleBtn" style="background: transparent; border: none; font-size: 1.25rem; color: var(--tx-m); padding: 0; display: none; align-items: center; justify-content: center;"><i class="fas fa-bars"></i></button>
        <div>
            <div class="tb-title">@yield('page_title', 'Dashboard')</div>
            <div class="tb-breadcrumb">
                <a href="{{ route('teacher.dashboard') }}">Home</a>
                <span>/</span>
                <span>@yield('page_title', 'Dashboard')</span>
            </div>
        </div>
    </div>
    <div class="tb-right">
        <div class="tb-user-info d-none d-sm-block" style="text-align:right; display: flex; flex-direction: column; justify-content: center;">
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
        <div class="dropdown" style="display: flex; align-items: center;">
            <div class="tb-avatar" data-bs-toggle="dropdown" aria-expanded="false" style="overflow: hidden; padding: 0; {{ (Auth::user() && Auth::user()->profile_image) ? 'background: #fff; box-shadow: 0 3px 10px rgba(5,150,105,0.3); border: 2px solid #fff;' : 'box-shadow: 0 3px 10px rgba(5,150,105,0.3); border: 2px solid #fff;' }}">
                @if(Auth::user() && Auth::user()->profile_image)
                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover; border-radius: inherit; display: block;">
                @else
                    {{ $initials }}
                @endif
            </div>
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
