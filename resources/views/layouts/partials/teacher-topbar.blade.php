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
        <div class="tb-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'T', 0, 2)) }}</div>
    </div>
</header>
