@extends('layouts.teacher')

@section('title', 'Course Materials — TeacherHub OBE')
@section('page_title', 'Course Materials')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
    .ts-wrapper.custom-ts { display: block !important; width: 100% !important; padding: 0 !important; border: none !important; background: transparent !important; box-shadow: none !important; margin: 0; }
    .ts-wrapper.custom-ts .ts-control { border: 1px solid #cbd5e1 !important; border-radius: 8px !important; background-color: #f8fafc !important; background-image: none !important; color: #334155 !important; font-size: 0.9rem !important; font-weight: 500 !important; padding: 10px 15px !important; min-height: 44px !important; box-shadow: none !important; display: flex !important; flex-wrap: nowrap !important; align-items: center; gap: 4px; overflow: hidden !important; transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease; }
    .ts-wrapper.custom-ts .ts-control > input { width: 0 !important; min-width: 0 !important; padding: 0 !important; margin: 0 !important; border: none !important; opacity: 0 !important; }
    .ts-wrapper.custom-ts.focus .ts-control { border-color: var(--primary) !important; background-color: #ffffff !important; box-shadow: 0 0 0 3px var(--primary-light) !important; outline: 0 !important; }
    .ts-dropdown { border: 1px solid #cbd5e1 !important; border-radius: 8px !important; background-color: #ffffff !important; box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important; z-index: 9999 !important; overflow: hidden; }
    .ts-dropdown .ts-dropdown-content { max-height: 250px !important; overflow-y: auto !important; padding: 5px 0; }
    .ts-dropdown .option[data-value=""] { display: none !important; }
    .ts-dropdown .option { padding: 8px 15px !important; color: #475569 !important; font-size: 0.9rem !important; cursor: pointer; }
    .ts-dropdown .option:hover, .ts-dropdown .active { background-color: #f1f5f9 !important; color: var(--primary) !important; }
    .ts-dropdown .dropdown-input-wrap { padding: 10px !important; border-bottom: 1px solid #e2e8f0 !important; background: #f8fafc; }
    .ts-dropdown .dropdown-input { border: 1px solid #cbd5e1 !important; border-radius: 6px !important; padding: 8px 12px !important; background: #ffffff !important; color: #334155 !important; font-size: 0.9rem !important; }
    .ts-dropdown .dropdown-input:focus { border-color: var(--primary) !important; outline: none; }
    .ts-control::after { content: ""; display: block; width: 8px; height: 8px; border-right: 2px solid #64748b; border-bottom: 2px solid #64748b; transform: rotate(45deg); position: absolute; right: 15px; top: 42%; transition: transform 0.2s ease; }
    .ts-wrapper.dropdown-active .ts-control::after { transform: rotate(-135deg); top: 48%; }

    .tm-breadcrumb { display:flex; align-items:center; flex-wrap:wrap; gap:6px; font-size:0.8rem; font-weight:600; color:var(--tx-s); margin-bottom:4px; }
    .tm-breadcrumb a { color:var(--tx-s); text-decoration:none; display:inline-flex; align-items:center; gap:6px; }
    .tm-breadcrumb a:hover { color:var(--primary); }
    .tm-breadcrumb .sep { color:var(--bd); font-weight:400; }
    .tm-breadcrumb .current { color:var(--tx-h); }

    .tm-stats { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:14px; margin-bottom:18px; }
    .tm-stat { background:#fff; border:1px solid var(--bd); border-radius:var(--r-lg); padding:16px 18px; display:flex; align-items:center; gap:14px; box-shadow:var(--sh-sm); }
    .tm-stat-ico { width:42px; height:42px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.05rem; flex-shrink:0; }
    .tm-stat-ico.green { background:var(--primary-light); color:var(--primary); }
    .tm-stat-ico.amber { background:#fffbeb; color:#f59e0b; }
    .tm-stat-ico.blue { background:#eff6ff; color:#3b82f6; }
    .tm-stat-label { font-size:0.72rem; font-weight:600; color:var(--tx-s); text-transform:uppercase; letter-spacing:0.04em; }
    .tm-stat-num { font-size:1.35rem; font-weight:800; color:var(--tx-h); line-height:1.2; }

    .tm-course-grid {
        display:grid;
        /* 5 columns → 15 items = 3 full rows (same as admin) */
        grid-template-columns:repeat(5,minmax(0,1fr));
        gap:16px;
        padding:4px 2px 8px;
    }
    @media (max-width:1400px) {
        .tm-course-grid { grid-template-columns:repeat(3,minmax(0,1fr)); }
    }
    @media (max-width:900px) {
        .tm-course-grid { grid-template-columns:repeat(2,minmax(0,1fr)); }
    }
    @media (max-width:520px) {
        .tm-course-grid { grid-template-columns:1fr; }
    }
    .tm-course-card {
        background:#fff; border:1px solid var(--bd); border-radius:var(--r-lg); padding:18px;
        text-decoration:none !important; color:inherit; display:flex; flex-direction:column; gap:12px;
        position:relative; overflow:hidden; cursor:pointer;
        box-shadow: 0 1px 2px rgba(15,23,42,0.04), 0 4px 12px rgba(15,23,42,0.05);
        transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
    }
    .tm-course-card::before {
        content:''; position:absolute; top:0; left:0; right:0; height:3px;
        background:linear-gradient(90deg, var(--primary), #34d399);
    }
    .tm-course-card:hover {
        border-color:#a7f3d0; transform:translateY(-3px);
        box-shadow: 0 8px 24px rgba(5,150,105,0.12), 0 4px 10px rgba(15,23,42,0.06);
    }
    .tm-course-top { display:flex; align-items:flex-start; justify-content:space-between; gap:10px; }
    .tm-course-ico { width:40px; height:40px; border-radius:10px; background:var(--primary-light); color:var(--primary); display:flex; align-items:center; justify-content:center; }
    .tm-course-title { font-size:0.92rem; font-weight:700; color:var(--tx-h); margin:0 0 4px; line-height:1.35; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .tm-course-meta { font-size:0.75rem; color:var(--tx-s); }
    .tm-course-stats { display:flex; align-items:center; gap:8px; flex-wrap:wrap; padding-top:12px; border-top:1px solid var(--bd-lt); margin-top:auto; }
    .tm-chip { display:inline-flex; align-items:center; gap:5px; font-size:0.72rem; font-weight:600; color:var(--tx-s); background:var(--bg-muted); border:1px solid var(--bd-lt); border-radius:6px; padding:4px 9px; }
    .tm-open { margin-left:auto; font-size:0.72rem; font-weight:700; color:var(--primary); background:var(--primary-light); border-radius:6px; padding:4px 10px; display:inline-flex; align-items:center; gap:5px; }
    .tm-course-card:hover .tm-open { background:var(--primary); color:#fff; }

    .tm-toolbar { display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:12px; padding:16px 20px; border-bottom:1px solid #e2e8f0; background:#fff; }
    .tm-toolbar form { display:flex; align-items:center; gap:8px; margin:0; }
    .tm-search { position:relative; width:220px; }
    .tm-search i { position:absolute; left:11px; top:50%; transform:translateY(-50%); color:var(--tx-m); font-size:0.78rem; pointer-events:none; }
    .tm-search input { width:100%; height:40px; padding:0 12px 0 34px; border:1px solid var(--bd); border-radius:8px; background:var(--bg-muted); font-size:0.82rem; color:var(--tx-b); outline:none; box-sizing:border-box; }
    .tm-search input:focus { border-color:var(--primary); box-shadow:0 0 0 3px var(--primary-glow); background:#fff; }
    .tm-toolbar .btn-primary, .tm-lib-actions .btn-primary, .tm-lib-actions .btn-ghost {
        height:40px; padding:0 16px; display:inline-flex; align-items:center; justify-content:center; gap:7px; box-sizing:border-box;
        font-size:0.82rem; font-weight:700; line-height:1; border-radius:8px;
    }
    .tm-lib-actions .btn-ghost,
    .tm-btn-folder {
        background:#ffffff; color:var(--primary); border:1.5px solid var(--primary);
        box-shadow:0 1px 2px rgba(5,150,105,0.08); transition:all 0.2s;
        height:40px; padding:0 16px; display:inline-flex; align-items:center; justify-content:center; gap:7px;
        box-sizing:border-box; font-size:0.82rem; font-weight:700; line-height:1; border-radius:8px; cursor:pointer;
    }
    .tm-lib-actions .btn-ghost:hover,
    .tm-btn-folder:hover {
        background:var(--primary-light); border-color:var(--primary-hover); color:var(--primary-hover);
    }
    .tm-lib-actions { display:flex; flex-wrap:wrap; align-items:center; gap:8px; }

    .fb-name { display:flex; align-items:center; gap:12px; min-width:0; }
    .fb-name .fb-text { min-width:0; flex:1; overflow:hidden; }
    .fb-ico { width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:0.95rem; }
    .fb-ico.folder { background:#fffbeb; color:#f59e0b; }
    .fb-ico.file { background:var(--primary-light); color:var(--primary); }
    .fb-ico.pdf { background:#fef2f2; color:#ef4444; }
    .fb-ico.doc { background:#eff6ff; color:#3b82f6; }
    .fb-ico.ppt { background:#fffbeb; color:#d97706; }
    .fb-ico.zip { background:#f8fafc; color:#64748b; }
    .fb-ico.img { background:#ecfeff; color:#06b6d4; }
    .fb-row-folder { cursor:pointer; }
    .fb-row-folder:hover td { background:#fffbeb !important; }
    .folder-badge {
        display:inline-flex; align-items:center; gap:5px; white-space:nowrap;
        background:#fffbeb; color:#92400e; border:1px solid #fde68a;
        border-radius:6px; padding:3px 9px; font-size:0.68rem; font-weight:700;
    }

    /* Match My Course Info / Announcements table rhythm */
    .tm-files-wrap.t-wrap { overflow-x:auto; -webkit-overflow-scrolling:touch; }
    .tm-files-table.t-tbl { min-width:900px; table-layout:fixed; width:100%; }
    .tm-files-table .t-name {
        font-size:0.85rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:100%;
    }
    .tm-files-table .t-sub {
        white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
    }
    .tm-files-table .action-group {
        display:flex; align-items:center; justify-content:flex-end; gap:6px; flex-wrap:nowrap;
    }
    .tm-files-table .action-group form { display:flex; align-items:center; margin:0; padding:0; }
    .tm-files-table .action-btn {
        width:32px; height:32px; min-width:32px; border-radius:6px;
        border:1px solid #cbd5e1; background:#f8fafc; color:#64748b;
        display:inline-flex; align-items:center; justify-content:center;
        font-size:0.82rem; line-height:1; cursor:pointer; transition:all 0.2s;
        text-decoration:none; box-sizing:border-box; padding:0;
    }
    .tm-files-table .action-btn:hover { background:#f1f5f9; color:var(--primary); border-color:#a7f3d0; }
    .tm-files-table .action-btn.open { background:var(--primary-light); color:var(--primary); border-color:#a7f3d0; }
    .tm-files-table .action-btn.open:hover { background:var(--primary); color:#fff; border-color:var(--primary); }
    .tm-files-table .action-btn.delete { color:#ef4444; }
    .tm-files-table .action-btn.delete:hover { background:#fef2f2; border-color:#fca5a5; color:#dc2626; }

    .upload-steps { display:flex; gap:8px; margin-bottom:16px; flex-wrap:wrap; }
    .upload-steps .step { flex:1; min-width:90px; text-align:center; padding:8px; border-radius:8px; background:var(--bg-muted); border:1px solid var(--bd-lt); font-size:0.72rem; font-weight:700; color:var(--tx-s); }
    .upload-steps .step span { display:block; color:var(--primary); margin-bottom:3px; }

    @media (max-width:1100px) {
        .tm-stats { grid-template-columns:1fr; }
    }
    @media (max-width:700px) {
        .tm-toolbar { flex-direction:column; align-items:stretch; }
        .tm-toolbar form, .tm-lib-actions { width:100%; }
        .tm-search { width:100%; flex:1; }
        .page-header { flex-direction:column !important; align-items:stretch !important; gap:12px; }
        .tm-lib-actions .btn-primary, .tm-lib-actions .btn-ghost { flex:1; }
    }
</style>
@endpush

@section('content')
<script>
    const allFoldersData = @json($folders ?? $allFolders ?? []);
</script>

<div class="page-header d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div class="heading-group">
        <h2 class="mb-1" style="font-size:1.5rem; font-weight:700; color:var(--tx-h); letter-spacing:-0.5px;">Course Materials</h2>
        <p class="text-muted m-0" style="font-size:0.85rem;">Browse by course, organize folders, and upload resources for your classes.</p>
    </div>
    <div class="tm-lib-actions">
        <button type="button" class="btn-ghost" data-bs-toggle="modal" data-bs-target="#createFolderModal"
            @if($activeCourse ?? null) onclick="prefillFolderCourse({{ $activeCourse->id }}, {{ $activeFolder->id ?? 'null' }}, @js($activeFolder?->name))" @endif>
            <i class="fas fa-folder-plus"></i> New Folder
        </button>
        <button type="button" class="btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal"
            @if($activeCourse ?? null) onclick="prefillUploadContext({{ $activeCourse->id }}, {{ $activeFolder->id ?? 'null' }})" @endif>
            <i class="fas fa-cloud-upload-alt"></i> Upload Material
        </button>
    </div>
</div>

<div class="tm-stats">
    <div class="tm-stat">
        <div class="tm-stat-ico green"><i class="fas fa-book-open"></i></div>
        <div>
            <div class="tm-stat-label">My Courses</div>
            <div class="tm-stat-num">{{ $courses->count() }}</div>
        </div>
    </div>
    <div class="tm-stat">
        <div class="tm-stat-ico blue"><i class="fas fa-file-lines"></i></div>
        <div>
            <div class="tm-stat-label">Total Files</div>
            <div class="tm-stat-num">{{ $totalFiles }}</div>
        </div>
    </div>
    <div class="tm-stat">
        <div class="tm-stat-ico amber"><i class="fas fa-folder"></i></div>
        <div>
            <div class="tm-stat-label">Folders</div>
            <div class="tm-stat-num">{{ $folderCount }}</div>
        </div>
    </div>
</div>

{{-- ===================== COURSE LIBRARY ===================== --}}
@if(($viewMode ?? 'library') === 'library')
<div class="d-card" style="animation-delay:.05s">
    <div class="d-card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <div class="d-card-title m-0"><div class="d-card-ico"><i class="fas fa-graduation-cap"></i></div>Select a Course</div>
            <p style="font-size:0.78rem; color:var(--tx-s); margin:4px 0 0 42px;">Open a course to manage its folders and materials</p>
        </div>
        <form action="{{ route('teacher.course-materials.index') }}" method="GET" class="d-flex align-items-center gap-2" style="margin:0;">
            <div class="tm-search">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Search courses..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn-primary" style="height:40px; padding:0 14px;"><i class="fas fa-search"></i> Search</button>
            @if(request('search'))
                <a href="{{ route('teacher.course-materials.index') }}" class="btn-ghost" style="height:40px; padding:0 12px;">Reset</a>
            @endif
        </form>
    </div>
    <div class="d-card-body">
        @if($courseLibrary && $courseLibrary->count() > 0)
            <div class="tm-course-grid">
                @foreach($courseLibrary as $course)
                <a href="{{ route('teacher.course-materials.index', ['course_id' => $course->id]) }}" class="tm-course-card">
                    <div class="tm-course-top">
                        <div class="tm-course-ico"><i class="fas fa-book-open"></i></div>
                        <span class="badge b-gray" style="font-size:0.7rem;">{{ $course->course_code }}</span>
                    </div>
                    <div>
                        <h6 class="tm-course-title">{{ $course->title }}</h6>
                        <div class="tm-course-meta">{{ $course->subtitle ?? 'Assigned course' }}</div>
                    </div>
                    <div class="tm-course-stats">
                        <span class="tm-chip"><i class="fas fa-file" style="color:var(--primary);"></i> {{ $course->materials_count }} file{{ $course->materials_count !== 1 ? 's' : '' }}</span>
                        <span class="tm-chip"><i class="fas fa-folder" style="color:#f59e0b;"></i> {{ $course->folders_count }} folder{{ $course->folders_count !== 1 ? 's' : '' }}</span>
                        <span class="tm-open">Open <i class="fas fa-arrow-right"></i></span>
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
                    <a href="{{ route('teacher.course-materials.index') }}" class="btn-primary mt-3" style="padding:9px 18px;">Clear Search</a>
                @else
                    <h5 style="color:var(--tx-h); font-weight:600;">No active courses this term</h5>
                    <p style="color:var(--tx-m); font-size:0.9rem; max-width:380px;">When courses are assigned to you for the running semester, they will appear here.</p>
                @endif
            </div>
        @endif
    </div>
</div>
@endif

{{-- ===================== COURSE FILE BROWSER ===================== --}}
@if(($viewMode ?? '') === 'browser' && $activeCourse)
<div class="d-card" style="animation-delay:.05s">
    <div class="tm-toolbar">
        <div style="min-width:0;">
            <div class="tm-breadcrumb">
                <a href="{{ route('teacher.course-materials.index') }}"><i class="fas fa-th-large"></i> All Courses</a>
                <span class="sep">/</span>
                @if($activeFolder)
                    <a href="{{ route('teacher.course-materials.index', ['course_id' => $activeCourse->id]) }}">{{ $activeCourse->course_code }}</a>
                    @foreach(($folderBreadcrumbs ?? collect()) as $crumb)
                        <span class="sep">/</span>
                        @if($loop->last)
                            <span class="current"><i class="fas fa-folder-open" style="color:#f59e0b;"></i> {{ $crumb->name }}</span>
                        @else
                            <a href="{{ route('teacher.course-materials.index', ['folder_id' => $crumb->id]) }}">{{ $crumb->name }}</a>
                        @endif
                    @endforeach
                @else
                    <span class="current">{{ $activeCourse->course_code }}</span>
                @endif
            </div>
            <h5 style="font-weight:700; color:var(--tx-h); margin:4px 0 0; font-size:1.05rem;">{{ $activeCourse->title }}</h5>
        </div>
        <form action="{{ route('teacher.course-materials.index') }}" method="GET">
            <input type="hidden" name="course_id" value="{{ $activeCourse->id }}">
            @if($activeFolder)
                <input type="hidden" name="folder_id" value="{{ $activeFolder->id }}">
            @endif
            <div class="tm-search">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Search files here..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn-primary" title="Search"><i class="fas fa-search"></i></button>
            @if(request('search'))
                <a href="{{ route('teacher.course-materials.index', array_filter(['course_id' => $activeCourse->id, 'folder_id' => $activeFolder->id ?? null])) }}" class="btn-ghost" style="height:40px; padding:0 12px;">Reset</a>
            @endif
        </form>
    </div>

    <div class="d-card-body p0">
        <div class="t-wrap tm-files-wrap">
            <table class="t-tbl tm-files-table">
                <thead>
                    <tr>
                        <th class="text-start" style="width:34%;">Name</th>
                        <th class="text-center" style="width:16%;">Type</th>
                        <th class="text-center" style="width:16%;">Privacy</th>
                        <th class="text-center" style="width:14%;">Size</th>
                        <th class="text-end" style="width:20%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($activeFolder)
                    @php
                        $backUrl = $activeFolder->parent_id
                            ? route('teacher.course-materials.index', ['folder_id' => $activeFolder->parent_id])
                            : route('teacher.course-materials.index', ['course_id' => $activeCourse->id]);
                        $backLabel = $activeFolder->parent_id ? '.. (Back to parent folder)' : '.. (Back to course root)';
                        $backSub = $activeFolder->parent_id ? 'Return to parent folder' : 'Return to folders & root files';
                    @endphp
                    <tr style="cursor:pointer;" onclick="window.location.href='{{ $backUrl }}'">
                        <td colspan="5" class="text-start">
                            <div class="fb-name">
                                <div class="fb-ico folder"><i class="fas fa-level-up-alt"></i></div>
                                <div class="fb-text">
                                    <div class="t-name">{{ $backLabel }}</div>
                                    <div class="t-sub">{{ $backSub }}</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif

                    @foreach($browserFolders as $folder)
                    <tr class="fb-row-folder" onclick="if(!event.target.closest('form,button,a')) window.location.href='{{ route('teacher.course-materials.index', ['folder_id' => $folder->id]) }}'">
                        <td class="text-start">
                            <div class="fb-name">
                                <div class="fb-ico folder"><i class="fas fa-folder"></i></div>
                                <div class="fb-text">
                                    <div class="t-name" title="{{ $folder->name }}">{{ $folder->name }}</div>
                                    <div class="t-sub">
                                        {{ $folder->materials_count }} file{{ $folder->materials_count !== 1 ? 's' : '' }}
                                        @if(($folder->children_count ?? 0) > 0)
                                            · {{ $folder->children_count }} subfolder{{ $folder->children_count !== 1 ? 's' : '' }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center"><span class="folder-badge"><i class="fas fa-folder"></i> Folder</span></td>
                        <td class="text-center"><span class="t-sub">—</span></td>
                        <td class="text-center"><span class="t-sub">—</span></td>
                        <td class="text-end" onclick="event.stopPropagation();">
                            <div class="action-group">
                                <a href="{{ route('teacher.course-materials.index', ['folder_id' => $folder->id]) }}" class="action-btn open" title="Open"><i class="fas fa-folder-open"></i></a>
                                <button type="button" class="action-btn js-rename-folder" title="Rename"
                                    data-bs-toggle="modal" data-bs-target="#renameFolderModal"
                                    data-id="{{ $folder->id }}"
                                    data-name="{{ $folder->name }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="{{ route('teacher.course-folders.destroy', $folder->id) }}" method="POST" class="folder-del-form">
                                    @csrf @method('DELETE')
                                    <button type="button" class="action-btn delete folder-delete-btn" title="Delete Folder"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
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
                    @endphp
                    <tr>
                        <td class="text-start">
                            <div class="fb-name">
                                <div class="fb-ico {{ $icoClass }}"><i class="fas {{ $ico }}"></i></div>
                                <div class="fb-text">
                                    <div class="t-name" title="{{ $material->title }}">{{ $material->title }}</div>
                                    <div class="t-sub">Uploaded {{ $material->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('teacher.course-materials.download', $material->id) }}" target="_blank" class="badge b-blue" style="text-decoration:none;">
                                <i class="fas {{ $ico }}"></i> {{ strtoupper($ext) }}
                            </a>
                        </td>
                        <td class="text-center">
                            @if($material->is_active)
                                <span class="badge b-green"><i class="fas fa-globe"></i> Students</span>
                            @else
                                <span class="badge b-gray"><i class="fas fa-lock"></i> Only Me</span>
                            @endif
                        </td>
                        <td class="text-center"><span style="font-weight:600;color:var(--tx-h);">{{ $sizeLabel }}</span></td>
                        <td class="text-end">
                            <div class="action-group">
                                @if(in_array($ext, ['pdf','png','jpg','jpeg','gif','webp']))
                                <button type="button" class="action-btn open js-preview-material" title="Preview"
                                    data-url="{{ route('teacher.course-materials.preview', $material->id) }}"
                                    data-title="{{ $material->title }}"
                                    data-ext="{{ $ext }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @endif
                                <a href="{{ route('teacher.course-materials.download', $material->id) }}" class="action-btn" title="Download" target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>
                                <button type="button" class="action-btn js-edit-material" title="Edit"
                                    data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-id="{{ $material->id }}"
                                    data-title="{{ $material->title }}"
                                    data-course-id="{{ $material->course_id }}"
                                    data-is-active="{{ $material->is_active ? 1 : 0 }}"
                                    data-folder-id="{{ $material->folder_id ?? '' }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="{{ route('teacher.course-materials.destroy', $material->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="action-btn delete delete-btn" type="button" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                        @if(request('search'))
                        <tr>
                            <td colspan="5">
                                <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding:48px 20px; text-align:center;">
                                    <div style="font-size:3rem; color:#cbd5e1; margin-bottom:12px;"><i class="fas fa-search"></i></div>
                                    <h5 style="color:var(--tx-h); font-weight:600;">No files match “{{ request('search') }}”</h5>
                                    <p style="color:var(--tx-m); font-size:0.9rem;">Folders above are not filtered by search. Try another keyword or clear search.</p>
                                </div>
                            </td>
                        </tr>
                        @elseif($browserFolders->isEmpty())
                        <tr>
                            <td colspan="5">
                                <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding:48px 20px; text-align:center;">
                                    <div style="font-size:3rem; color:#cbd5e1; margin-bottom:12px;"><i class="fas fa-folder-open"></i></div>
                                    @if($activeFolder)
                                        <h5 style="color:var(--tx-h); font-weight:600;">This folder is empty</h5>
                                        <p style="color:var(--tx-m); font-size:0.9rem;">Create a subfolder or upload files here.</p>
                                        <div class="d-flex gap-2 mt-3 justify-content-center flex-wrap">
                                            <button type="button" class="tm-btn-folder" data-bs-toggle="modal" data-bs-target="#createFolderModal"
                                                onclick="prefillFolderCourse({{ $activeCourse->id }}, {{ $activeFolder->id }}, @js($activeFolder->name))"><i class="fas fa-folder-plus"></i> New Folder</button>
                                            <button type="button" class="btn-primary" style="height:40px; padding:0 16px;" data-bs-toggle="modal" data-bs-target="#uploadModal"
                                                onclick="prefillUploadContext({{ $activeCourse->id }}, {{ $activeFolder->id }})"><i class="fas fa-cloud-upload-alt"></i> Upload</button>
                                        </div>
                                    @else
                                        <h5 style="color:var(--tx-h); font-weight:600;">No materials in this course yet</h5>
                                        <p style="color:var(--tx-m); font-size:0.9rem;">Create a folder or upload files to get started.</p>
                                        <div class="d-flex gap-2 mt-3 justify-content-center flex-wrap">
                                            <button type="button" class="tm-btn-folder" data-bs-toggle="modal" data-bs-target="#createFolderModal"
                                                onclick="prefillFolderCourse({{ $activeCourse->id }}, null, null)"><i class="fas fa-folder-plus"></i> New Folder</button>
                                            <button type="button" class="btn-primary" style="height:40px; padding:0 16px;" data-bs-toggle="modal" data-bs-target="#uploadModal"
                                                onclick="prefillUploadContext({{ $activeCourse->id }}, null)"><i class="fas fa-cloud-upload-alt"></i> Upload</button>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endif
                    @endforelse
                </tbody>
            </table>
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
{{-- Upload Modal --}}
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border:none; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.15); overflow:hidden;">
            <form action="{{ route('teacher.course-materials.store') }}" method="POST" enctype="multipart/form-data" id="uploadMaterialForm">
                @csrf
                <div class="modal-header" style="background:linear-gradient(135deg,var(--primary,#059669) 0%,#2563eb 100%); color:#fff; border-top-left-radius:16px; border-top-right-radius:16px; padding:1.25rem 1.5rem; border-bottom:none;">
                    <h5 class="modal-title" style="font-weight:700; font-size:1.1rem; margin:0; display:flex; align-items:center; gap:8px; color:#fff;">
                        <i class="fas fa-cloud-upload-alt"></i> Upload Material
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="opacity:0.9;"></button>
                </div>
                <div class="modal-body">
                    <div class="upload-steps">
                        <div class="step"><span>1</span> Choose Course</div>
                        <div class="step"><span>2</span> Folder (optional)</div>
                        <div class="step"><span>3</span> Title &amp; File</div>
                    </div>
                    <div class="fg">
                        <label class="flabel">Course <span style="color:var(--danger)">*</span></label>
                        <select class="finput" name="course_id" id="add_course_id" required>
                            <option value="">— Select Course —</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_code }} — {{ $course->title }}</option>
                            @endforeach
                        </select>
                        <small style="color:var(--tx-m); font-size:0.72rem; margin-top:4px; display:block;">File will be attached to this course only.</small>
                    </div>
                    <div class="fg">
                        <label class="flabel">Save to Folder <span style="color:var(--tx-s); font-weight:400;">(Optional)</span></label>
                        <select class="finput" name="folder_id" id="add_folder_id">
                            <option value="">Root (No Folder)</option>
                        </select>
                    </div>
                    <div class="fg">
                        <label class="flabel">Material Title <span style="color:var(--danger)">*</span></label>
                        <input type="text" class="finput" name="title" placeholder="e.g. Lecture 01 — Introduction" required>
                    </div>
                    <div class="fg">
                        <label class="flabel">File Privacy</label>
                        <div class="priv-seg">
                            <input type="radio" name="is_active" value="1" id="pub" checked>
                            <label for="pub"><i class="fas fa-globe" style="font-size:.72rem;"></i> Visible to students</label>
                            <input type="radio" name="is_active" value="0" id="me">
                            <label for="me"><i class="fas fa-lock" style="font-size:.70rem;"></i> Only Me</label>
                        </div>
                    </div>
                    <div class="fg" style="margin-bottom:0;">
                        <label class="flabel">Upload File <span style="color:var(--danger)">*</span></label>
                        <div class="upload-z" id="dropZone" onclick="document.getElementById('fileIn').click()">
                            <div class="upload-z-ico"><i class="fas fa-file-arrow-up"></i></div>
                            <div class="upload-z-txt" id="fileText">Click or drag &amp; drop your file here</div>
                            <div class="upload-z-hint">PDF · DOC/DOCX · PPT/PPTX · XLS · ZIP · images (JPG/PNG/GIF/WEBP) · TXT — Max 20 MB</div>
                            <input type="file" hidden id="fileIn" name="file" required
                                accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.csv,.zip,.rar,.7z,.jpg,.jpeg,.png,.gif,.webp,.txt"
                                onchange="document.getElementById('fileText').innerText = this.files[0] ? this.files[0].name : 'Click or drag & drop your file here'">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal"
                        style="padding:10px 24px; border-radius:8px; border:1px solid #cbd5e1; background:#ffffff; color:#475569; box-shadow:0 1px 2px rgba(0,0,0,0.05); transition:all 0.2s;"
                        onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#ffffff'">Cancel</button>
                    <button type="submit" class="btn-primary"><i class="fas fa-upload"></i> Confirm Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Create Folder Modal --}}
<div class="modal fade" id="createFolderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:none; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.15); overflow:hidden;">
            <form action="{{ route('teacher.course-folders.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="background:linear-gradient(135deg,var(--primary,#059669) 0%,#2563eb 100%); color:#fff; border-top-left-radius:16px; border-top-right-radius:16px; padding:1.25rem 1.5rem; border-bottom:none;">
                    <h5 class="modal-title" style="font-weight:700; font-size:1.1rem; margin:0; display:flex; align-items:center; gap:8px; color:#fff;">
                        <i class="fas fa-folder-plus"></i> Create New Folder
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="opacity:0.9;"></button>
                </div>
                <div class="modal-body">
                    <p style="font-size:0.85rem; color:var(--tx-s); margin:0 0 16px;" id="createFolderHint">Folders belong to one course. You can create nested folders inside another folder.</p>
                    <input type="hidden" name="parent_id" id="modal_create_parent" value="">
                    <div class="fg">
                        <label class="flabel">Course <span style="color:var(--danger)">*</span></label>
                        <select class="finput" name="course_id" id="modal_create_course" required>
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_code }} — {{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fg" id="createFolderParentRow" style="display:none;">
                        <label class="flabel">Parent Folder</label>
                        <input type="text" class="finput" id="modal_create_parent_label" readonly
                            style="background:#f8fafc; color:var(--tx-s);">
                    </div>
                    <div class="fg" style="margin-bottom:0;">
                        <label class="flabel">Folder Name <span style="color:var(--danger)">*</span></label>
                        <input type="text" class="finput" name="name" placeholder="e.g. Lecture Notes, Week 1..." required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal"
                        style="padding:10px 24px; border-radius:8px; border:1px solid #cbd5e1; background:#ffffff; color:#475569; box-shadow:0 1px 2px rgba(0,0,0,0.05); transition:all 0.2s;"
                        onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#ffffff'">Cancel</button>
                    <button type="submit" class="btn-primary"><i class="fas fa-folder-plus"></i> Create Folder</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Rename Folder Modal --}}
<div class="modal fade" id="renameFolderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:none; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.15); overflow:hidden;">
            <form id="renameFolderForm" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="stay_in_folder" value="0" id="rename_stay_flag">
                <div class="modal-header" style="background:linear-gradient(135deg,#1e293b 0%,#334155 100%); color:#fff; border-top-left-radius:16px; border-top-right-radius:16px; padding:1.25rem 1.5rem; border-bottom:none;">
                    <h5 class="modal-title" style="font-weight:700; font-size:1.1rem; margin:0; display:flex; align-items:center; gap:8px; color:#fff;">
                        <i class="fas fa-pen"></i> Rename Folder
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="opacity:0.9;"></button>
                </div>
                <div class="modal-body">
                    <div class="fg" style="margin-bottom:0;">
                        <label class="flabel">Folder Name <span style="color:var(--danger)">*</span></label>
                        <input type="text" class="finput" name="name" id="rename_folder_name" required maxlength="100">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal"
                        style="padding:10px 24px; border-radius:8px; border:1px solid #cbd5e1; background:#ffffff; color:#475569; box-shadow:0 1px 2px rgba(0,0,0,0.05); transition:all 0.2s;"
                        onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#ffffff'">Cancel</button>
                    <button type="submit" class="btn-primary"><i class="fas fa-check"></i> Save Name</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:none; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.15); overflow:hidden;">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header" style="background:linear-gradient(135deg,#1e293b 0%,#334155 100%); color:#fff; border-top-left-radius:16px; border-top-right-radius:16px; padding:1.25rem 1.5rem; border-bottom:none;">
                    <h5 class="modal-title" style="font-weight:700; font-size:1.1rem; margin:0; display:flex; align-items:center; gap:8px; color:#fff;">
                        <i class="fas fa-pen"></i> Edit Material
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="opacity:0.9;"></button>
                </div>
                <div class="modal-body">
                    <div class="fg">
                        <label class="flabel">Material Title</label>
                        <input type="text" class="finput" name="title" id="edit_title" required>
                    </div>
                    <div class="fg">
                        <label class="flabel">Course</label>
                        <select class="finput" name="course_id" id="edit_course_id" required>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_code }} — {{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fg">
                        <label class="flabel">Folder <span style="color:var(--tx-s);font-weight:400;">(Optional)</span></label>
                        <select class="finput" name="folder_id" id="edit_folder_id">
                            <option value="">Root (No Folder)</option>
                        </select>
                    </div>
                    <div class="fg">
                        <label class="flabel">Privacy</label>
                        <select class="finput" name="is_active" id="edit_privacy" required>
                        <option value="1">Visible to students</option>
                        <option value="0">Only Me</option>
                        </select>
                    </div>
                    <div class="fg" style="margin-bottom:0;">
                        <label class="flabel">Replace File (Optional)</label>
                        <div class="upload-z" id="dropZoneEdit" onclick="document.getElementById('fileInEdit').click()">
                            <div class="upload-z-ico"><i class="fas fa-file-arrow-up"></i></div>
                            <div class="upload-z-txt" id="fileTextEdit">Click or drag &amp; drop to replace file</div>
                            <div class="upload-z-hint">PDF · DOC/DOCX · PPT/PPTX · XLS · ZIP · images (JPG/PNG/GIF/WEBP) · TXT — Max 20 MB</div>
                            <input type="file" hidden id="fileInEdit" name="file"
                                accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.csv,.zip,.rar,.7z,.jpg,.jpeg,.png,.gif,.webp,.txt"
                                onchange="document.getElementById('fileTextEdit').innerText = this.files[0] ? this.files[0].name : 'Click or drag & drop to replace file'">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal"
                        style="padding:10px 24px; border-radius:8px; border:1px solid #cbd5e1; background:#ffffff; color:#475569; box-shadow:0 1px 2px rgba(0,0,0,0.05); transition:all 0.2s;"
                        onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#ffffff'">Cancel</button>
                    <button type="submit" class="btn-primary"><i class="fas fa-check"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Preview Modal --}}
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="border:none; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.15); overflow:hidden;">
            <div class="modal-header" style="background:linear-gradient(135deg,var(--primary,#059669) 0%,#2563eb 100%); color:#fff; border-top-left-radius:16px; border-top-right-radius:16px; padding:1.25rem 1.5rem; border-bottom:none;">
                <h5 class="modal-title" id="previewModalLabel" style="font-weight:700; font-size:1.1rem; margin:0; display:flex; align-items:center; gap:8px; color:#fff;">
                    <i class="fas fa-eye"></i> File Preview
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="opacity:0.9;"></button>
            </div>
            <div class="modal-body p-0" style="height:80vh; background:#f8f9fa; position:relative;">
                <div id="iframeLoader" style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); z-index:1;">
                    <div class="spinner-border text-success" role="status" style="width:3rem; height:3rem;"><span class="visually-hidden">Loading...</span></div>
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
        bootstrap.Modal.getOrCreateInstance(document.getElementById('previewModal')).show();
    }
    document.getElementById('previewModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('previewIframe').src = '';
        document.getElementById('previewImage').src = '';
        document.getElementById('iframeLoader').style.display = 'none';
    });

    document.addEventListener('click', function(e) {
        const previewBtn = e.target.closest('.js-preview-material');
        if (previewBtn) {
            openPreviewModal(previewBtn.dataset.url, previewBtn.dataset.title, previewBtn.dataset.ext);
            return;
        }
        const editBtn = e.target.closest('.js-edit-material');
        if (editBtn) {
            populateEditModal(
                editBtn.dataset.id,
                editBtn.dataset.title,
                editBtn.dataset.courseId,
                editBtn.dataset.isActive,
                editBtn.dataset.folderId || null
            );
            return;
        }
        const renameBtn = e.target.closest('.js-rename-folder');
        if (renameBtn) {
            const form = document.getElementById('renameFolderForm');
            const nameInput = document.getElementById('rename_folder_name');
            if (form && nameInput) {
                form.action = @json(url('/teacher/course-folders')) + '/' + renameBtn.dataset.id;
                nameInput.value = renameBtn.dataset.name || '';
            }
        }
    });

    function loadFolders(courseId, selectId, selectedFolderId) {
        const select = document.getElementById(selectId);
        if (!select) return;
        const ts = select.tomselect;
        if (ts) {
            ts.clearOptions();
            ts.addOption({ value: '', text: 'Root (No Folder)' });
            if (courseId) {
                (allFoldersData[courseId] || []).forEach(function(folder) {
                    ts.addOption({ value: String(folder.id), text: folder.path_label || folder.name });
                });
            }
            ts.refreshOptions(false);
            ts.setValue(selectedFolderId ? String(selectedFolderId) : '');
        } else {
            select.innerHTML = '<option value="">Root (No Folder)</option>';
            if (!courseId) return;
            (allFoldersData[courseId] || []).forEach(function(folder) {
                const opt = document.createElement('option');
                opt.value = folder.id;
                opt.textContent = folder.path_label || folder.name;
                if (selectedFolderId && String(folder.id) === String(selectedFolderId)) opt.selected = true;
                select.appendChild(opt);
            });
        }
    }

    function prefillUploadContext(courseId, folderId) {
        setTimeout(function() {
            const el = document.getElementById('add_course_id');
            if (el && el.tomselect) el.tomselect.setValue(String(courseId));
            else if (el) { el.value = courseId; loadFolders(courseId, 'add_folder_id', folderId); }
            setTimeout(function() { loadFolders(courseId, 'add_folder_id', folderId); }, 80);
        }, 150);
    }

    function prefillFolderCourse(courseId, parentId, parentName) {
        setTimeout(function() {
            const el = document.getElementById('modal_create_course');
            if (el && el.tomselect) el.tomselect.setValue(String(courseId));
            else if (el) el.value = courseId;

            const parentInput = document.getElementById('modal_create_parent');
            const parentRow = document.getElementById('createFolderParentRow');
            const parentLabel = document.getElementById('modal_create_parent_label');
            const hint = document.getElementById('createFolderHint');
            if (parentId) {
                if (parentInput) parentInput.value = parentId;
                if (parentRow) parentRow.style.display = 'block';
                if (parentLabel) parentLabel.value = parentName || ('Folder #' + parentId);
                if (hint) hint.textContent = 'This folder will be created inside the parent folder below.';
            } else {
                if (parentInput) parentInput.value = '';
                if (parentRow) parentRow.style.display = 'none';
                if (parentLabel) parentLabel.value = '';
                if (hint) hint.textContent = 'Folders belong to one course. You can create nested folders inside another folder.';
            }
        }, 150);
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    let editCourseSelect, editPrivacySelect;

    document.addEventListener('DOMContentLoaded', function() {
        const tsConfig = {
            create: false, controlInput: null, maxOptions: null, allowEmptyOption: true,
            wrapperClass: 'ts-wrapper custom-ts', plugins: ['dropdown_input'],
            sortField: { field: 'text', direction: 'asc' },
            onDelete: function(values, e) { return e ? false : true; }
        };

        if (document.getElementById('add_course_id')) {
            const addC = new TomSelect('#add_course_id', tsConfig);
            const si = addC.dropdown.querySelector('input');
            if (si) si.setAttribute('placeholder', 'Search course...');
            addC.on('change', function(val) { loadFolders(val, 'add_folder_id'); });
        }
        if (document.getElementById('add_folder_id')) {
            const addF = new TomSelect('#add_folder_id', tsConfig);
            const si = addF.dropdown.querySelector('input');
            if (si) si.setAttribute('placeholder', 'Search folder...');
        }
        if (document.getElementById('modal_create_course')) {
            const mc = new TomSelect('#modal_create_course', tsConfig);
            const si = mc.dropdown.querySelector('input');
            if (si) si.setAttribute('placeholder', 'Search course...');
        }
        if (document.getElementById('edit_course_id')) {
            editCourseSelect = new TomSelect('#edit_course_id', tsConfig);
            const si = editCourseSelect.dropdown.querySelector('input');
            if (si) si.setAttribute('placeholder', 'Search course...');
            editCourseSelect.on('change', function(val) { loadFolders(val, 'edit_folder_id'); });
        }
        if (document.getElementById('edit_folder_id')) {
            const ef = new TomSelect('#edit_folder_id', tsConfig);
            const si = ef.dropdown.querySelector('input');
            if (si) si.setAttribute('placeholder', 'Search folder...');
        }
        if (document.getElementById('edit_privacy')) {
            editPrivacySelect = new TomSelect('#edit_privacy', {
                create: false, controlInput: null, maxOptions: null,
                wrapperClass: 'ts-wrapper custom-ts',
                onDelete: function(values, e) { return e ? false : true; }
            });
        }

        const dz = document.getElementById('dropZone');
        if (dz) {
            ['dragover','dragenter'].forEach(e => dz.addEventListener(e, ev => { ev.preventDefault(); dz.style.borderColor = 'var(--primary)'; dz.style.background = 'var(--primary-light)'; }));
            ['dragleave','drop'].forEach(e => dz.addEventListener(e, ev => { ev.preventDefault(); dz.style.borderColor = ''; dz.style.background = ''; }));
            dz.addEventListener('drop', function(ev) {
                const files = ev.dataTransfer.files;
                if (files && files[0]) {
                    const input = document.getElementById('fileIn');
                    try {
                        const dt = new DataTransfer();
                        dt.items.add(files[0]);
                        input.files = dt.files;
                    } catch (err) { /* older browsers: label still updates */ }
                    document.getElementById('fileText').innerText = files[0].name;
                }
            });
        }
        const dzEdit = document.getElementById('dropZoneEdit');
        if (dzEdit) {
            ['dragover','dragenter'].forEach(e => dzEdit.addEventListener(e, ev => { ev.preventDefault(); dzEdit.style.borderColor = 'var(--primary)'; dzEdit.style.background = 'var(--primary-light)'; }));
            ['dragleave','drop'].forEach(e => dzEdit.addEventListener(e, ev => { ev.preventDefault(); dzEdit.style.borderColor = ''; dzEdit.style.background = ''; }));
            dzEdit.addEventListener('drop', function(ev) {
                const files = ev.dataTransfer.files;
                if (files && files[0]) {
                    const input = document.getElementById('fileInEdit');
                    try {
                        const dt = new DataTransfer();
                        dt.items.add(files[0]);
                        input.files = dt.files;
                    } catch (err) { /* older browsers */ }
                    document.getElementById('fileTextEdit').innerText = files[0].name;
                }
            });
        }

        // Material delete uses global .delete-btn handler in sweetalert partial (avoid double confirm).
        document.querySelectorAll('.folder-delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault(); e.stopPropagation();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Delete Folder?', text: 'Subfolders will also be deleted. Files inside will move to course root.',
                    icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8', confirmButtonText: 'Yes, delete folder!'
                }).then((r) => { if (r.isConfirmed) form.submit(); });
            });
        });

        @if($activeCourse ?? null)
        document.getElementById('uploadModal')?.addEventListener('show.bs.modal', function() {
            prefillUploadContext({{ $activeCourse->id }}, {{ $activeFolder->id ?? 'null' }});
        });
        document.getElementById('createFolderModal')?.addEventListener('show.bs.modal', function() {
            prefillFolderCourse({{ $activeCourse->id }}, {{ $activeFolder->id ?? 'null' }}, @js($activeFolder?->name));
        });
        @endif
    });

    function populateEditModal(id, title, courseId, isActive, folderId) {
        document.getElementById('editForm').action = @json(url('/teacher/course-materials')) + '/' + id;
        document.getElementById('edit_title').value = title || '';
        if (editCourseSelect) editCourseSelect.setValue(String(courseId));
        else document.getElementById('edit_course_id').value = courseId;
        loadFolders(courseId, 'edit_folder_id', folderId ? folderId : null);
        if (editPrivacySelect) editPrivacySelect.setValue(String(isActive));
        else document.getElementById('edit_privacy').value = isActive;
        document.getElementById('fileInEdit').value = '';
        document.getElementById('fileTextEdit').innerText = 'Click or drag & drop to replace file';
    }
</script>
@endpush
