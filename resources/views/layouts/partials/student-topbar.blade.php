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
        <div class="tb-user-info d-none d-sm-block">
            <div class="tb-uname">{{ Auth::user()->name ?? 'Student' }}</div>
            <div class="tb-urole">Student</div>
        </div>
        <div class="tb-avatar">
            @if(Auth::user() && Auth::user()->profile_image)
                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
            @else
                {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 2)) }}
            @endif
        </div>
    </div>
</header>
