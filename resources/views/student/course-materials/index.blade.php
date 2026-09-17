@extends('layouts.student')

@section('title', 'Course Materials — StudentHub OBE')
@section('page-title', 'Course Materials')
@section('breadcrumb', 'Course Materials')

@push('styles')
<style>
    .sm-stats { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:14px; margin-bottom:18px; }
    .sm-stat {
        background:var(--bg-card); border:1px solid var(--bd); border-radius:var(--r-lg);
        padding:16px 18px; display:flex; align-items:center; gap:14px; box-shadow:var(--sh-sm);
        backdrop-filter:blur(8px);
    }
    .sm-stat-ico {
        width:42px; height:42px; border-radius:10px; display:flex; align-items:center;
        justify-content:center; font-size:1.05rem; flex-shrink:0;
    }
    .sm-stat-ico.blue { background:var(--primary-light); color:var(--primary); }
    .sm-stat-ico.green { background:#e6f9ed; color:#00c950; }
    .sm-stat-ico.amber { background:#fff5e6; color:#ff9900; }
    .sm-stat-label { font-size:0.72rem; font-weight:600; color:var(--tx-s); text-transform:uppercase; letter-spacing:0.04em; }
    .sm-stat-num { font-size:1.35rem; font-weight:800; color:var(--tx-h); line-height:1.2; }

    .sm-course-grid {
        display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:16px; padding:4px 2px 8px;
    }
    @media (max-width:1200px) { .sm-course-grid { grid-template-columns:repeat(2,minmax(0,1fr)); } }
    @media (max-width:640px) {
        .sm-stats { grid-template-columns:1fr; }
        .sm-course-grid { grid-template-columns:1fr; }
        .sm-toolbar { flex-direction:column; align-items:stretch; }
        .sm-search { width:100%; }
    }

    .sm-course-card {
        background:#fff; border:1px solid var(--bd); border-radius:var(--r-lg); padding:18px;
        text-decoration:none !important; color:inherit; display:flex; flex-direction:column; gap:12px;
        position:relative; overflow:hidden; cursor:pointer;
        box-shadow:var(--sh-sm); transition:border-color var(--base) var(--ease), box-shadow var(--base) var(--ease), transform var(--base) var(--ease);
    }
    .sm-course-card::before {
        content:''; position:absolute; top:0; left:0; right:0; height:3px;
        background:linear-gradient(90deg, var(--primary), #60a5fa);
    }
    .sm-course-card:hover {
        border-color:#93c5fd; transform:translateY(-3px);
        box-shadow:0 8px 24px rgba(0,102,255,0.12), 0 4px 10px rgba(15,23,42,0.06);
    }
    .sm-course-top { display:flex; align-items:flex-start; justify-content:space-between; gap:10px; }
    .sm-course-ico {
        width:40px; height:40px; border-radius:10px; background:var(--primary-light); color:var(--primary);
        display:flex; align-items:center; justify-content:center;
    }
    .sm-course-title {
        font-size:0.92rem; font-weight:700; color:var(--tx-h); margin:0 0 4px; line-height:1.35;
        display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
    }
    .sm-course-meta { font-size:0.75rem; color:var(--tx-s); }
    .sm-course-stats {
        display:flex; align-items:center; gap:8px; flex-wrap:wrap;
        padding-top:12px; border-top:1px solid var(--bd-lt); margin-top:auto;
    }
    .sm-chip {
        display:inline-flex; align-items:center; gap:5px; font-size:0.72rem; font-weight:600;
        color:var(--tx-s); background:var(--bg-muted); border:1px solid var(--bd-lt);
        border-radius:6px; padding:4px 9px;
    }
    .sm-open {
        margin-left:auto; font-size:0.72rem; font-weight:700; color:var(--primary);
        background:var(--primary-light); border-radius:6px; padding:4px 10px;
        display:inline-flex; align-items:center; gap:5px;
    }
    .sm-course-card:hover .sm-open { background:var(--primary); color:#fff; }

    .sm-toolbar {
        display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between;
        gap:12px; padding:16px 20px; border-bottom:1px solid var(--bd); background:#fff;
    }
    .sm-toolbar form { display:flex; align-items:center; gap:8px; margin:0; flex-wrap:wrap; }
    .sm-search { position:relative; width:220px; }
    .sm-search i {
        position:absolute; left:11px; top:50%; transform:translateY(-50%);
        color:var(--tx-m); font-size:0.78rem; pointer-events:none;
    }
    .sm-search input {
        width:100%; height:40px; padding:0 12px 0 34px; border:1px solid var(--bd);
        border-radius:8px; background:var(--bg-muted); font-size:0.82rem; color:var(--tx-b);
        outline:none; box-sizing:border-box;
    }
    .sm-search input:focus {
        border-color:var(--primary); box-shadow:0 0 0 3px var(--primary-glow); background:#fff;
    }

    .sm-breadcrumb {
        display:flex; align-items:center; flex-wrap:wrap; gap:6px;
        font-size:0.8rem; font-weight:600; color:var(--tx-s); margin-bottom:4px;
    }
    .sm-breadcrumb a { color:var(--tx-s); text-decoration:none; display:inline-flex; align-items:center; gap:6px; }
    .sm-breadcrumb a:hover { color:var(--primary); }
    .sm-breadcrumb .sep { color:var(--bd); font-weight:400; }
    .sm-breadcrumb .current { color:var(--tx-h); }

    .sm-files-wrap {
        overflow-x:auto; -webkit-overflow-scrolling:touch;
    }
    /* Equal-gap file browser grid (Drive / OneDrive style) */
    .sm-file-list { min-width:760px; width:100%; }
    .sm-file-row {
        display:grid;
        grid-template-columns: minmax(0, 1.35fr) repeat(4, minmax(0, 1fr));
        column-gap:20px;
        align-items:center;
        padding:14px 20px;
        border-bottom:1px solid var(--bd-lt);
        box-sizing:border-box;
        transition:background var(--fast, 0.15s);
    }
    .sm-file-row:last-child { border-bottom:none; }
    .sm-file-row.is-head {
        padding:12px 20px;
        background:rgba(247,248,249,0.7);
        border-bottom:2px solid var(--bd-lt);
    }
    .sm-file-row.is-head span {
        font-size:0.68rem; font-weight:700; color:var(--tx-s);
        text-transform:uppercase; letter-spacing:1px;
    }
    .sm-file-row:not(.is-head):hover { background:rgba(0,102,255,0.03); }
    .sm-file-row.is-folder { cursor:pointer; }
    .sm-file-row .c-name { min-width:0; }
    .sm-file-row .c-type,
    .sm-file-row .c-size,
    .sm-file-row .c-date,
    .sm-file-row .c-action {
        display:flex; align-items:center; justify-content:center; min-width:0;
    }
    .sm-file-row.is-head .c-name { justify-content:flex-start; text-align:left; }
    .sm-file-row .c-action { justify-content:flex-end; }
    .sm-file-row.is-head .c-action { justify-content:flex-end; }
    .sm-file-list .t-name {
        font-size:0.85rem; font-weight:600; color:var(--tx-h);
        white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:100%;
    }
    .sm-file-list .t-sub {
        white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
        color:var(--tx-s); font-size:0.75rem;
    }
    .sm-file-list .cell-muted { color:var(--tx-s); font-weight:500; }
    .sm-file-list .cell-size { font-weight:600; color:var(--tx-h); font-size:0.82rem; }
    .sm-file-list .cell-date { color:var(--tx-s); font-size:0.78rem; font-weight:500; }
    .sm-file-empty { padding:48px 20px; text-align:center; }
    .fb-name { display:flex; align-items:center; gap:12px; min-width:0; }
    .fb-name .fb-text { min-width:0; flex:1; overflow:hidden; }
    .fb-ico {
        width:36px; height:36px; border-radius:8px; display:flex; align-items:center;
        justify-content:center; flex-shrink:0; font-size:0.95rem;
    }
    .fb-ico.folder { background:#fffbeb; color:#f59e0b; }
    .fb-ico.file { background:var(--primary-light); color:var(--primary); }
    .fb-ico.pdf { background:#fef2f2; color:#ef4444; }
    .fb-ico.doc { background:#eff6ff; color:#3b82f6; }
    .fb-ico.ppt { background:#fffbeb; color:#d97706; }
    .fb-ico.zip { background:#f8fafc; color:#64748b; }
    .fb-ico.img { background:#ecfeff; color:#06b6d4; }
    .folder-badge {
        display:inline-flex; align-items:center; gap:5px; white-space:nowrap;
        background:#fffbeb; color:#92400e; border:1px solid #fde68a;
        border-radius:6px; padding:3px 9px; font-size:0.68rem; font-weight:700;
    }
    .type-badge {
        display:inline-flex; align-items:center; gap:5px; white-space:nowrap;
        border-radius:6px; padding:3px 9px; font-size:0.68rem; font-weight:700;
    }
    .sm-action-group {
        display:flex; align-items:center; justify-content:flex-end; gap:8px; flex-wrap:nowrap;
        min-height:32px;
    }
    .sm-action-btn {
        width:32px; height:32px; min-width:32px; border-radius:6px;
        border:1px solid #cbd5e1; background:#f8fafc; color:#64748b;
        display:inline-flex; align-items:center; justify-content:center;
        font-size:0.82rem; line-height:1; cursor:pointer; transition:all 0.2s;
        text-decoration:none; box-sizing:border-box; padding:0;
    }
    .sm-action-btn:hover { background:#eff6ff; color:var(--primary); border-color:#93c5fd; }
    .sm-action-btn.open { background:var(--primary-light); color:var(--primary); border-color:#93c5fd; }
    .sm-action-btn.open:hover { background:var(--primary); color:#fff; border-color:var(--primary); }
    .sm-action-btn.dl { color:#059669; }
    .sm-action-btn.dl:hover { background:#ecfdf5; color:#059669; border-color:#6ee7b7; }

    .sm-lib-search { display:flex; align-items:center; gap:8px; margin:0; flex-wrap:wrap; }
    .sm-lib-search .btn-primary,
    .sm-lib-search .btn-ghost,
    .sm-toolbar .btn-primary,
    .sm-toolbar .btn-ghost {
        height:40px; padding:0 16px; display:inline-flex; align-items:center; justify-content:center;
        box-sizing:border-box; font-size:0.82rem; font-weight:700; border-radius:8px; text-decoration:none;
    }
    .sm-lib-search .btn-ghost,
    .sm-toolbar .btn-ghost {
        background:#fff; color:var(--tx-s); border:1.5px solid var(--bd);
    }
    .sm-lib-search .btn-ghost:hover,
    .sm-toolbar .btn-ghost:hover {
        background:var(--bg-muted); color:var(--tx-h); border-color:#94a3b8;
    }

    /* Download ZIP — Drive / OneDrive style control */
    .sm-zip-btn {
        height:40px; padding:0 16px; display:inline-flex; align-items:center; justify-content:center;
        gap:6px; box-sizing:border-box; white-space:nowrap; text-decoration:none;
        font-size:0.82rem; font-weight:700; border-radius:8px; cursor:pointer;
        background:#fff; color:#334155; border:1.5px solid #cbd5e1;
        box-shadow:0 1px 2px rgba(15,23,42,0.06), 0 4px 10px rgba(15,23,42,0.08);
        transition: background 0.18s ease, color 0.18s ease, border-color 0.18s ease,
                    box-shadow 0.18s ease, transform 0.18s ease;
    }
    .sm-zip-btn:hover {
        background:#eff6ff; color:#1d4ed8; border-color:#93c5fd;
        box-shadow:0 2px 4px rgba(37,99,235,0.12), 0 8px 18px rgba(37,99,235,0.18);
        transform:translateY(-1px);
    }
    .sm-zip-btn:active {
        transform:translateY(0);
        box-shadow:0 1px 2px rgba(15,23,42,0.08);
    }
</style>
@endpush

@section('content')

<div class="sm-stats">
    <div class="sm-stat">
        <div class="sm-stat-ico blue"><i class="fas fa-book-open"></i></div>
        <div>
            <div class="sm-stat-label">My Courses</div>
            <div class="sm-stat-num">{{ $courses->count() }}</div>
        </div>
    </div>
    <div class="sm-stat">
        <div class="sm-stat-ico green"><i class="fas fa-file-lines"></i></div>
        <div>
            <div class="sm-stat-label">Available Files</div>
            <div class="sm-stat-num">{{ $totalFiles }}</div>
        </div>
    </div>
    <div class="sm-stat">
        <div class="sm-stat-ico amber"><i class="fas fa-folder"></i></div>
        <div>
            <div class="sm-stat-label">Folders</div>
            <div class="sm-stat-num">{{ $folderCount }}</div>
        </div>
    </div>
</div>

{{-- ===================== COURSE LIBRARY ===================== --}}
@if(($viewMode ?? 'library') === 'library')
<div class="d-card" style="animation-delay:.05s">
    <div class="d-card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <div class="d-card-title m-0">
                <div class="d-card-ico" style="background:var(--primary-light);color:var(--primary);"><i class="fas fa-graduation-cap"></i></div>
                Select a Course
            </div>
            <p style="font-size:0.78rem; color:var(--tx-s); margin:4px 0 0 42px;">Open a course to browse folders and download materials from your teachers</p>
        </div>
        <form action="{{ route('student.course-materials.index') }}" method="GET" class="sm-lib-search">
            <div class="sm-search">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Search courses..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn-primary" style="height:40px; padding:0 14px;"><i class="fas fa-search"></i> Search</button>
            @if(request('search'))
                <a href="{{ route('student.course-materials.index') }}" class="btn-ghost">Reset</a>
            @endif
        </form>
    </div>
    <div class="d-card-body">
        @if($courseLibrary && $courseLibrary->count() > 0)
            <div class="sm-course-grid">
                @foreach($courseLibrary as $course)
                <a href="{{ route('student.course-materials.index', ['course_id' => $course->id]) }}" class="sm-course-card">
                    <div class="sm-course-top">
                        <div class="sm-course-ico"><i class="fas fa-book-open"></i></div>
                        <span class="badge b-gray" style="font-size:0.7rem;">{{ $course->course_code }}</span>
                    </div>
                    <div>
                        <h6 class="sm-course-title">{{ $course->title }}</h6>
                        <div class="sm-course-meta">{{ optional($course->teacher)->name ?? 'Instructor' }}</div>
                    </div>
                    <div class="sm-course-stats">
                        <span class="sm-chip"><i class="fas fa-file" style="color:var(--primary);"></i> {{ $course->public_files_count }} file{{ $course->public_files_count !== 1 ? 's' : '' }}</span>
                        <span class="sm-chip"><i class="fas fa-folder" style="color:#f59e0b;"></i> {{ $course->folders_count }} folder{{ $course->folders_count !== 1 ? 's' : '' }}</span>
                        <span class="sm-open">Open <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
                @endforeach
            </div>
            @if($courseLibrary->hasPages())
                <div style="padding-top:14px; border-top:1px solid var(--bd-lt); margin-top:8px;">
                    {{ $courseLibrary->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @else
            <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding:48px 20px; text-align:center;">
                <div style="font-size:3rem; color:#cbd5e1; margin-bottom:12px;"><i class="fas fa-book-open"></i></div>
                @if(request('search'))
                    <h5 style="color:var(--tx-h); font-weight:600;">No courses match “{{ request('search') }}”</h5>
                    <p style="color:var(--tx-m); font-size:0.9rem; max-width:380px;">Try another keyword, or use Reset above to clear search.</p>
                @else
                    <h5 style="color:var(--tx-h); font-weight:600;">No courses enrolled</h5>
                    <p style="color:var(--tx-m); font-size:0.9rem; max-width:380px;">When you are enrolled in active courses, their materials will appear here.</p>
                @endif
            </div>
        @endif
    </div>
</div>
@endif

{{-- ===================== COURSE FILE BROWSER ===================== --}}
@if(($viewMode ?? '') === 'browser' && $activeCourse)
<div class="d-card" style="animation-delay:.05s">
    <div class="sm-toolbar">
        <div style="min-width:0;">
            <div class="sm-breadcrumb">
                <a href="{{ route('student.course-materials.index') }}"><i class="fas fa-th-large"></i> All Courses</a>
                <span class="sep">/</span>
                @if($activeFolder)
                    <a href="{{ route('student.course-materials.index', ['course_id' => $activeCourse->id]) }}">{{ $activeCourse->course_code }}</a>
                    @foreach(($folderBreadcrumbs ?? collect()) as $crumb)
                        <span class="sep">/</span>
                        @if($loop->last)
                            <span class="current"><i class="fas fa-folder-open" style="color:#f59e0b;"></i> {{ $crumb->name }}</span>
                        @else
                            <a href="{{ route('student.course-materials.index', ['folder_id' => $crumb->id]) }}">{{ $crumb->name }}</a>
                        @endif
                    @endforeach
                @else
                    <span class="current">{{ $activeCourse->course_code }}</span>
                @endif
            </div>
            <h5 style="font-weight:700; color:var(--tx-h); margin:4px 0 0; font-size:1.05rem;">{{ $activeCourse->title }}</h5>
        </div>
        <form action="{{ route('student.course-materials.index') }}" method="GET" style="display:flex; align-items:center; gap:8px; margin:0; flex-wrap:wrap;">
            <input type="hidden" name="course_id" value="{{ $activeCourse->id }}">
            @if($activeFolder)
                <input type="hidden" name="folder_id" value="{{ $activeFolder->id }}">
            @endif
            @if($activeFolder)
                <a href="{{ route('student.course-folders.download', $activeFolder->id) }}" class="sm-zip-btn" title="Download this folder as ZIP">
                    <i class="fas fa-file-zipper"></i> Download ZIP
                </a>
            @endif
            <div class="sm-search">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Search folders & files..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn-primary" title="Search" style="height:40px; padding:0 14px;"><i class="fas fa-search"></i></button>
            @if(request('search'))
                <a href="{{ route('student.course-materials.index', array_filter(['course_id' => $activeCourse->id, 'folder_id' => $activeFolder->id ?? null])) }}" class="btn-ghost">Reset</a>
            @endif
        </form>
    </div>

    <div class="d-card-body p0">
        <div class="sm-files-wrap">
            <div class="sm-file-list" role="table" aria-label="Course materials">
                <div class="sm-file-row is-head" role="row">
                    <span class="c-name" role="columnheader">Name</span>
                    <span class="c-type" role="columnheader">Type</span>
                    <span class="c-size" role="columnheader">Size</span>
                    <span class="c-date" role="columnheader">Uploaded</span>
                    <span class="c-action" role="columnheader">Action</span>
                </div>

                @if($activeFolder)
                @php
                    $backUrl = $activeFolder->parent_id
                        ? route('student.course-materials.index', ['folder_id' => $activeFolder->parent_id])
                        : route('student.course-materials.index', ['course_id' => $activeCourse->id]);
                    $backLabel = $activeFolder->parent_id ? '.. (Back to parent folder)' : '.. (Back to course root)';
                    $backSub = $activeFolder->parent_id ? 'Return to parent folder' : 'Return to folders & root files';
                @endphp
                <div class="sm-file-row is-folder" role="row" onclick="window.location.href='{{ $backUrl }}'">
                    <div class="c-name" role="cell">
                        <div class="fb-name">
                            <div class="fb-ico folder"><i class="fas fa-level-up-alt"></i></div>
                            <div class="fb-text">
                                <div class="t-name">{{ $backLabel }}</div>
                                <div class="t-sub">{{ $backSub }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="c-type" role="cell"></div>
                    <div class="c-size" role="cell"></div>
                    <div class="c-date" role="cell"></div>
                    <div class="c-action" role="cell"></div>
                </div>
                @endif

                @foreach($browserFolders as $folder)
                <div class="sm-file-row is-folder" role="row" onclick="window.location.href='{{ route('student.course-materials.index', ['folder_id' => $folder->id]) }}'">
                    <div class="c-name" role="cell">
                        <div class="fb-name">
                            <div class="fb-ico folder"><i class="fas fa-folder"></i></div>
                            <div class="fb-text">
                                <div class="t-name" title="{{ $folder->name }}">{{ $folder->name }}</div>
                                <div class="t-sub">
                                    {{ $folder->public_files_count }} file{{ $folder->public_files_count !== 1 ? 's' : '' }}
                                    @if(($folder->children_count ?? 0) > 0)
                                        · {{ $folder->children_count }} subfolder{{ $folder->children_count !== 1 ? 's' : '' }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="c-type" role="cell"><span class="folder-badge"><i class="fas fa-folder"></i> Folder</span></div>
                    <div class="c-size" role="cell"><span class="cell-muted">—</span></div>
                    <div class="c-date" role="cell"><span class="cell-muted">—</span></div>
                    <div class="c-action" role="cell" onclick="event.stopPropagation();">
                        <div class="sm-action-group">
                            <a href="{{ route('student.course-materials.index', ['folder_id' => $folder->id]) }}" class="sm-action-btn open" title="Open"><i class="fas fa-folder-open"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach

                @forelse($materials as $material)
                @php
                    $ext = strtolower($material->file_type ?? 'file');
                    $ico = 'fa-file-alt'; $icoClass = 'file';
                    if ($ext === 'pdf') { $ico = 'fa-file-pdf'; $icoClass = 'pdf'; }
                    elseif (in_array($ext, ['doc','docx'])) { $ico = 'fa-file-word'; $icoClass = 'doc'; }
                    elseif (in_array($ext, ['ppt','pptx'])) { $ico = 'fa-file-powerpoint'; $icoClass = 'ppt'; }
                    elseif (in_array($ext, ['zip','rar','7z'])) { $ico = 'fa-file-archive'; $icoClass = 'zip'; }
                    elseif (in_array($ext, ['jpg','jpeg','png','gif','webp'])) { $ico = 'fa-file-image'; $icoClass = 'img'; }
                    $size = $material->file_size ?? 0;
                    $sizeLabel = $size < 1024 ? $size.' B' : ($size < 1048576 ? round($size/1024,1).' KB' : round($size/1048576,2).' MB');
                    $previewable = in_array($ext, ['pdf','png','jpg','jpeg','gif','webp'], true);
                    $typeColors = [
                        'pdf' => ['#fef2f2','#dc2626'],
                        'doc' => ['#eff6ff','#2563eb'],
                        'docx' => ['#eff6ff','#2563eb'],
                        'ppt' => ['#fffbeb','#d97706'],
                        'pptx' => ['#fffbeb','#d97706'],
                        'zip' => ['#faf5ff','#7c3aed'],
                        'png' => ['#ecfeff','#0891b2'],
                        'jpg' => ['#ecfeff','#0891b2'],
                        'jpeg' => ['#ecfeff','#0891b2'],
                    ];
                    $tc = $typeColors[$ext] ?? ['#f1f5f9','#475569'];
                @endphp
                <div class="sm-file-row" role="row">
                    <div class="c-name" role="cell">
                        <div class="fb-name">
                            <div class="fb-ico {{ $icoClass }}"><i class="fas {{ $ico }}"></i></div>
                            <div class="fb-text">
                                <div class="t-name" title="{{ $material->title }}">{{ $material->title }}</div>
                                <div class="t-sub">Uploaded {{ $material->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="c-type" role="cell">
                        <span class="type-badge" style="background:{{ $tc[0] }}; color:{{ $tc[1] }};">{{ strtoupper($ext) }}</span>
                    </div>
                    <div class="c-size" role="cell"><span class="cell-size">{{ $sizeLabel }}</span></div>
                    <div class="c-date" role="cell"><span class="cell-date">{{ $material->created_at->format('d M Y') }}</span></div>
                    <div class="c-action" role="cell">
                        <div class="sm-action-group">
                            @if($previewable)
                            <button type="button" class="sm-action-btn open js-preview-material" title="Preview"
                                data-url="{{ route('student.course-materials.preview', $material->id) }}"
                                data-title="{{ e($material->title) }}"
                                data-ext="{{ $ext }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            @endif
                            <a href="{{ route('student.course-materials.download', $material->id) }}" class="sm-action-btn dl" title="Download">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                    @if(request('search') && $browserFolders->isEmpty())
                    <div class="sm-file-empty">
                        <div style="font-size:3rem; color:#cbd5e1; margin-bottom:12px;"><i class="fas fa-search"></i></div>
                        <h5 style="color:var(--tx-h); font-weight:600;">No folders or files match “{{ request('search') }}”</h5>
                        <p style="color:var(--tx-m); font-size:0.9rem; margin:0;">Try another keyword or clear search.</p>
                    </div>
                    @elseif(!request('search') && $browserFolders->isEmpty())
                    <div class="sm-file-empty">
                        <div style="font-size:3rem; color:#cbd5e1; margin-bottom:12px;"><i class="fas fa-folder-open"></i></div>
                        <h5 style="color:var(--tx-h); font-weight:600;">
                            {{ $activeFolder ? 'This folder is empty' : 'No materials in this course yet' }}
                        </h5>
                        <p style="color:var(--tx-m); font-size:0.9rem; margin:0;">
                            {{ $activeFolder ? 'Your teacher has not added files here yet.' : 'When your teacher uploads files, they will appear here.' }}
                        </p>
                    </div>
                    @endif
                @endforelse
            </div>
        </div>
        @if($materials && $materials->hasPages())
            <div style="padding:12px 16px; border-top:1px solid var(--bd-lt);">
                {{ $materials->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endif

@endsection

@push('modals')
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="border:none; border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background:linear-gradient(135deg,var(--primary,#0066ff) 0%,#2563eb 100%); color:#fff; border:none; padding:1.25rem 1.5rem;">
                <h5 class="modal-title" id="previewModalLabel" style="font-weight:700; margin:0; display:flex; align-items:center; gap:8px; color:#fff;">
                    <i class="fas fa-eye"></i> File Preview
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="opacity:0.9;"></button>
            </div>
            <div class="modal-body p-0" style="height:80vh; background:#f8f9fa; position:relative;">
                <div id="iframeLoader" style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); z-index:1;">
                    <div class="spinner-border text-primary" role="status" style="width:3rem; height:3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <iframe id="previewIframe" src="" style="width:100%; height:100%; border:none; position:relative; z-index:2;"></iframe>
                <img id="previewImage" src="" alt="Preview" style="width:100%; height:100%; object-fit:contain; position:relative; z-index:2; display:none; margin:auto;">
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function openPreviewModal(url, title, ext) {
        const modalEl = document.getElementById('previewModal');
        if (!modalEl) return;
        document.getElementById('previewModalLabel').innerText = title || 'File Preview';
        document.getElementById('iframeLoader').style.display = 'block';
        const isImage = ['png','jpg','jpeg','gif','webp'].includes(ext ? ext.toLowerCase() : '');
        const iframe = document.getElementById('previewIframe');
        const img = document.getElementById('previewImage');
        if (isImage) {
            iframe.style.display = 'none'; iframe.src = '';
            img.style.display = 'block'; img.src = url;
            img.onload = function() { document.getElementById('iframeLoader').style.display = 'none'; };
        } else {
            img.style.display = 'none'; img.src = '';
            iframe.style.display = 'block'; iframe.src = url;
            iframe.onload = function() { document.getElementById('iframeLoader').style.display = 'none'; };
        }
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.js-preview-material');
            if (!btn) return;
            openPreviewModal(btn.dataset.url, btn.dataset.title, btn.dataset.ext);
        });

        const previewModal = document.getElementById('previewModal');
        if (previewModal) {
            previewModal.addEventListener('hidden.bs.modal', function() {
                document.getElementById('previewIframe').src = '';
                document.getElementById('previewImage').src = '';
                document.getElementById('iframeLoader').style.display = 'none';
            });
        }
    });
</script>
@endpush
