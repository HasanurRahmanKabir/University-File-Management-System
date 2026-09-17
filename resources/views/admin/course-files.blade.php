@extends('layouts.admin')
@section('title', 'Course Files - Admin Dashboard')
@section('page-title', 'Course Materials')
@section('breadcrumb', 'Course Files')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
    /* TomSelect — match admin form controls */
    .ts-wrapper.form-select { padding: 0 !important; border: none !important; background: transparent !important; box-shadow: none !important; }
    .ts-control { border: 1.5px solid #475569 !important; border-radius: var(--radius-md) !important; background: var(--bg-input) !important; color: var(--text-body) !important; font-size: 0.85rem !important; padding: 9px 13px !important; min-height: 42px !important; box-shadow: var(--shadow-sm) !important; display: flex; align-items: center; transition: all var(--duration-base) var(--ease); }
    .ts-wrapper.focus .ts-control { border-color: var(--primary) !important; box-shadow: 0 0 0 3px var(--primary-glow) !important; background: white !important; outline: none !important; }
    .ts-wrapper.ts-faculty:not(.has-items) .ts-control::before { content: "Select Faculty"; display: block !important; color: var(--text-secondary) !important; font-weight: 500 !important; }
    .ts-wrapper.ts-course:not(.has-items) .ts-control::before { content: "Select Course"; display: block !important; color: var(--text-secondary) !important; font-weight: 500 !important; }
    .ts-control .item[data-value=""] { display: block !important; opacity: 1 !important; visibility: visible !important; color: var(--text-secondary) !important; font-weight: 500 !important; }
    .ts-wrapper:not(.has-items) .ts-control .item[data-value=""] { display: none !important; }
    .ts-dropdown { border: 1px solid var(--border) !important; border-radius: var(--radius-md) !important; background-color: white !important; box-shadow: var(--shadow-md) !important; z-index: 9999 !important; }
    .ts-dropdown .option[data-value=""] { display: none !important; }
    .ts-dropdown .option { padding: 8px 14px !important; color: var(--text-body) !important; font-size: 0.85rem !important; }
    .ts-dropdown .option:hover, .ts-dropdown .active { background-color: var(--bg-muted) !important; color: var(--primary) !important; }
    .ts-dropdown .dropdown-input-wrap { padding: 8px !important; border-bottom: 1px solid var(--border-light) !important; }
    .ts-dropdown .dropdown-input { border: 1px solid var(--border) !important; border-radius: var(--radius-sm) !important; padding: 6px 12px !important; background: var(--bg-muted) !important; color: var(--text-body) !important; font-size: 0.85rem !important; }
    .ts-control::after { content: ""; display: block; width: 10px; height: 10px; border-right: 2px solid #888; border-bottom: 2px solid #888; transform: rotate(45deg); position: absolute; right: 15px; top: 40%; transition: transform 0.2s ease; }
    .ts-wrapper.dropdown-active .ts-control::after { transform: rotate(-135deg); top: 45%; }
    .ts-wrapper.dropdown-active .ts-control .item, .ts-wrapper.has-items .ts-control .item { display: block !important; opacity: 1 !important; }
    .ts-dropdown .ts-dropdown-content { max-height: 250px; overflow-y: auto; }
    .ts-wrapper.form-select .ts-control { flex-wrap: nowrap !important; overflow: hidden !important; }
    .ts-wrapper.form-select .ts-control > input { width: 0 !important; min-width: 0 !important; padding: 0 !important; margin: 0 !important; border: none !important; opacity: 0 !important; }

    /* Breadcrumb */
    .cf-breadcrumb {
        display: flex; align-items: center; flex-wrap: wrap; gap: 6px;
        font-size: 0.82rem; font-weight: 600; color: var(--text-secondary);
        margin-bottom: 4px;
    }
    .cf-breadcrumb a {
        color: var(--text-secondary); text-decoration: none;
        display: inline-flex; align-items: center; gap: 6px;
        transition: color 0.15s;
    }
    .cf-breadcrumb a:hover { color: var(--primary); }
    .cf-breadcrumb .sep { color: var(--border); font-weight: 400; }
    .cf-breadcrumb .current { color: var(--text-heading); }

    /* View switcher — segmented control */
    .cf-view-switch {
        display: inline-flex;
        align-items: stretch;
        gap: 0;
        background: #fff;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-md);
        padding: 0;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .cf-view-switch a {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 16px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-heading);
        text-decoration: none;
        background: #fff;
        border: none;
        border-right: 1.5px solid var(--border);
        transition: background 0.15s, color 0.15s, box-shadow 0.15s;
        cursor: pointer;
        line-height: 1.2;
        white-space: nowrap;
    }
    .cf-view-switch a:last-child { border-right: none; }
    .cf-view-switch a i {
        font-size: 0.78rem;
        color: var(--text-secondary);
        transition: color 0.15s;
    }
    .cf-view-switch a:hover {
        background: var(--primary-light);
        color: var(--primary);
    }
    .cf-view-switch a:hover i { color: var(--primary); }
    .cf-view-switch a.active {
        background: var(--primary);
        color: #fff;
        box-shadow: inset 0 0 0 1px var(--primary);
    }
    .cf-view-switch a.active i { color: #fff; }
    .cf-view-switch a.active:hover {
        background: var(--primary-hover);
        color: #fff;
    }
    .cf-view-switch a.active:hover i { color: #fff; }

    /* Course library grid */
    .course-lib-grid {
        display: grid;
        /* 5 columns → 15 items = 3 full rows (no half row) */
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 20px;
        padding: 22px 24px 28px;
        background: #f8fafc;
    }
    @media (max-width: 1400px) {
        .course-lib-grid {
            /* 3 columns → 15 items = 5 full rows */
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }
    @media (max-width: 900px) {
        .course-lib-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            padding: 16px;
        }
    }
    @media (max-width: 520px) {
        .course-lib-grid {
            grid-template-columns: 1fr;
            gap: 12px;
            padding: 12px;
        }
    }
    .course-lib-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-lg);
        padding: 18px;
        cursor: pointer;
        text-decoration: none !important;
        color: inherit;
        display: flex;
        flex-direction: column;
        gap: 14px;
        position: relative;
        overflow: hidden;
        box-shadow:
            0 1px 2px rgba(15, 23, 42, 0.04),
            0 4px 12px rgba(15, 23, 42, 0.06),
            0 8px 24px rgba(15, 23, 42, 0.04);
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }
    .course-lib-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, var(--primary), #8b5cf6);
        opacity: 1;
    }
    .course-lib-card:hover {
        border-color: #c7d2fe;
        transform: translateY(-4px);
        box-shadow:
            0 4px 8px rgba(15, 23, 42, 0.06),
            0 12px 28px rgba(99, 102, 241, 0.14),
            0 20px 40px rgba(15, 23, 42, 0.08);
    }
    .course-lib-card:active {
        transform: translateY(-1px);
        box-shadow:
            0 2px 6px rgba(15, 23, 42, 0.06),
            0 8px 16px rgba(99, 102, 241, 0.1);
    }
    .course-lib-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
    .course-lib-icon {
        width: 42px; height: 42px; border-radius: var(--radius-md);
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(99, 102, 241, 0.12);
    }
    .course-lib-title {
        font-size: 0.92rem; font-weight: 700; color: var(--text-heading);
        line-height: 1.35; margin: 0 0 4px;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .course-lib-meta {
        font-size: 0.75rem; color: var(--text-secondary);
        display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
    }
    .course-lib-stats {
        display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
        padding-top: 12px; border-top: 1px solid #f1f5f9;
        margin-top: auto;
    }
    .course-lib-stat {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 0.72rem; font-weight: 600; color: var(--text-secondary);
        background: #f8fafc; border: 1px solid #eef2f7;
        border-radius: 6px; padding: 4px 9px;
    }
    .course-lib-stat i { font-size: 0.7rem; }
    .course-lib-open {
        margin-left: auto;
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--primary);
        display: inline-flex;
        align-items: center;
        gap: 5px;
        opacity: 1;
        padding: 4px 10px;
        border-radius: 6px;
        background: var(--primary-light);
        transition: background 0.15s, color 0.15s;
    }
    .course-lib-card:hover .course-lib-open {
        background: var(--primary);
        color: #fff;
    }

    /* File browser rows */
    .fb-row-folder td { background: #fffbeb22; }
    .fb-row-folder:hover td { background: #fffbeb !important; }
    .fb-name-cell { display: flex; align-items: center; gap: 12px; }
    .fb-ico {
        width: 38px; height: 38px; border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.05rem; flex-shrink: 0;
    }
    .fb-ico.folder { background: #fffbeb; color: #f59e0b; }
    .fb-ico.file { background: var(--primary-light); color: var(--primary); }
    .fb-ico.pdf { background: #fff1f2; color: #f43f5e; }
    .fb-ico.doc { background: #eff6ff; color: #3b82f6; }
    .fb-ico.xls { background: #ecfdf5; color: #10b981; }
    .fb-ico.ppt { background: #fff1f2; color: #e11d48; }
    .fb-ico.zip { background: #fffbeb; color: #d97706; }
    .fb-ico.img { background: #ecfeff; color: #06b6d4; }
    .folder-badge {
        background: #fffbeb; color: #92400e; border-radius: 5px;
        padding: 2px 8px; font-size: 0.72rem; font-weight: 700;
    }
    .cf-toolbar {
        display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between;
        gap: 12px; padding: 14px 24px; border-bottom: 1px solid var(--border-light);
        background: linear-gradient(180deg, #fafbff 0%, #fff 100%);
    }
    .cf-toolbar form {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }
    .cf-toolbar .search-box {
        width: 240px;
        min-width: 200px;
    }
    .cf-toolbar .search-box input {
        height: 40px !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        box-sizing: border-box;
    }
    .cf-toolbar form .btn,
    .cf-toolbar .btn {
        height: 40px !important;
        min-height: 40px !important;
        min-width: 40px;
        padding: 0 14px !important;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        line-height: 1 !important;
        flex-shrink: 0;
    }
    .cf-step-hint {
        font-size: 0.75rem; color: var(--text-secondary); margin-top: 4px;
        display: flex; align-items: center; gap: 6px;
    }
    .cf-step-hint i { color: var(--primary); }
    .upload-steps {
        display: flex; gap: 8px; margin-bottom: 18px; flex-wrap: wrap;
    }
    .upload-steps .step {
        flex: 1; min-width: 100px; text-align: center;
        padding: 8px 10px; border-radius: var(--radius-md);
        background: var(--bg-muted); border: 1px solid var(--border-light);
        font-size: 0.72rem; font-weight: 700; color: var(--text-secondary);
    }
    .upload-steps .step i { display: block; margin-bottom: 4px; font-size: 0.9rem; color: var(--primary); }

    /* Library filter toolbar — single professional row */
    .cf-lib-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: nowrap;
        padding: 18px 22px;
        border-bottom: 1px solid var(--border-light);
        background: white;
    }
    .cf-lib-header .cf-lib-title-block { min-width: 0; flex-shrink: 1; }
    .cf-filter-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
        margin: 0;
    }
    .cf-filter-bar .cf-dept-select {
        width: 180px;
        min-width: 180px;
        max-width: 180px;
        height: 40px;
        padding: 0 34px 0 12px;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        background: var(--bg-muted);
        font-size: 0.8rem;
        font-family: inherit;
        color: var(--text-body);
        outline: none;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .cf-filter-bar .cf-dept-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-glow);
        background-color: #fff;
    }
    .cf-filter-bar .search-box {
        width: 240px;
        min-width: 240px;
    }
    .cf-filter-bar .search-box input {
        height: 40px;
        padding-top: 0;
        padding-bottom: 0;
    }
    .cf-filter-bar .btn {
        height: 40px;
        padding: 0 16px;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }
    .cf-filter-bar .cf-clear-link {
        height: 40px;
        padding: 0 12px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-decoration: none;
        border: 1px solid var(--border-light);
        border-radius: var(--radius-md);
        background: #fff;
        transition: all 0.15s;
        white-space: nowrap;
    }
    .cf-filter-bar .cf-clear-link:hover {
        color: var(--danger);
        border-color: #fecaca;
        background: #fff1f2;
    }
    @media (max-width: 992px) {
        .cf-lib-header {
            flex-direction: column;
            align-items: stretch;
        }
        .cf-filter-bar,
        #searchForm.cf-filter-bar {
            flex-direction: row;
            flex-wrap: wrap;
            width: 100%;
            align-items: stretch !important;
        }
        .cf-filter-bar .cf-dept-select,
        .cf-filter-bar .search-box,
        #searchForm.cf-filter-bar .search-box {
            width: 100% !important;
            min-width: 0;
            max-width: none;
            flex: 1 1 100%;
        }
        .cf-filter-bar .btn,
        .cf-filter-bar .cf-clear-link,
        #searchForm.cf-filter-bar .btn {
            flex: 1;
            width: auto;
            justify-content: center;
        }
    }
    @media (min-width: 993px) {
        #searchForm.cf-filter-bar {
            flex-direction: row !important;
            width: auto !important;
            align-items: center !important;
        }
        #searchForm.cf-filter-bar .search-box {
            width: 240px !important;
        }
        #searchForm.cf-filter-bar .btn {
            width: auto !important;
        }
    }

    /* Page header + actions — tiny devices */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column !important;
            align-items: stretch !important;
        }
        .page-header .d-flex.flex-wrap {
            width: 100%;
            margin-right: 0 !important;
        }
        .cf-view-switch {
            width: 100%;
        }
        .cf-view-switch a {
            flex: 1;
            justify-content: center;
            padding: 10px 12px;
            font-size: 0.75rem;
        }
        .page-header .btn {
            flex: 1;
            justify-content: center;
            min-width: 0;
        }
        .course-lib-card {
            padding: 14px;
        }
        .course-lib-title {
            font-size: 0.88rem;
        }
        .course-lib-stats {
            gap: 6px;
        }
        .course-lib-open {
            width: 100%;
            justify-content: center;
            margin-left: 0;
            margin-top: 4px;
            order: 3;
            flex: 1 1 100%;
        }
        .cf-toolbar {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }
        .cf-toolbar form {
            width: 100%;
        }
        .cf-toolbar .search-box {
            width: 100% !important;
            flex: 1;
        }
        .stats-grid.grid-3 {
            grid-template-columns: 1fr !important;
        }
    }
    @media (max-width: 400px) {
        .cf-view-switch a {
            padding: 9px 8px;
            font-size: 0.7rem;
            gap: 4px;
        }
        .course-lib-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
        }
        .course-lib-card .badge.dark {
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div class="heading-group">
        <h2>Course Materials</h2>
        <p>Browse by course, organize folders, and manage uploaded files.</p>
    </div>
    <div class="d-flex flex-wrap align-items-center gap-2" style="margin-right: 8px;">
        <div class="cf-view-switch" role="group" aria-label="View mode">
            <a href="{{ route('admin.course-files.index') }}"
               class="{{ $viewMode === 'library' || $viewMode === 'browser' ? 'active' : '' }}"
               title="Browse materials course by course">
                <i class="fas fa-th-large"></i> By Course
            </a>
            <a href="{{ route('admin.course-files.index', ['view' => 'all']) }}"
               class="{{ $viewMode === 'all_files' ? 'active' : '' }}"
               title="See every uploaded file in one list">
                <i class="fas fa-list"></i> All Files
            </a>
        </div>
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#createFolderModal"
            @if($activeCourse) onclick="prefillFolderCourse({{ $activeCourse->id }}, {{ $activeFolder->id ?? 'null' }}, @js($activeFolder?->name))" @endif>
            <i class="fas fa-folder-plus"></i> New Folder
        </button>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal"
            @if($activeCourse) onclick="prefillUploadContext({{ $activeCourse->id }}, {{ $activeFolder->id ?? 'null' }})" @endif>
            <i class="fas fa-cloud-upload-alt"></i> Upload Material
        </button>
    </div>
</div>

{{-- Stats --}}
<div class="stats-grid grid-3">
    <div class="stat-card">
        <div class="stat-icon-wrap blue"><i class="fas fa-file-lines"></i></div>
        <div class="stat-info">
            <div class="stat-label">Total Files</div>
            <div class="stat-number">{{ $totalFiles }}</div>
            <div class="stat-trend up"><i class="fas fa-arrow-up"></i> {{ $weeklyFiles }} this week</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrap rose"><i class="fas fa-file-pdf"></i></div>
        <div class="stat-info">
            <div class="stat-label">PDF Documents</div>
            <div class="stat-number">{{ $pdfCount }}</div>
            <div class="stat-trend neutral"><i class="fas fa-check"></i> {{ $pdfPercentage }}% of files</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrap emerald"><i class="fas fa-hard-drive"></i></div>
        <div class="stat-info">
            <div class="stat-label">Storage Used</div>
            <div class="stat-number">{{ $storageUsed }}</div>
            <div class="stat-trend neutral"><i class="fas fa-database"></i> of 10 GB</div>
        </div>
    </div>
</div>

<script>
    const adminAllFolders = @json($allFolders);
    const adminCoursesData = @json($coursesForJs);
</script>

{{-- ===================== COURSE LIBRARY ===================== --}}
@if($viewMode === 'library')
<div class="data-card">
    <div class="cf-lib-header">
        <div class="cf-lib-title-block">
            <h5 class="card-title mb-0"><i class="fas fa-graduation-cap"></i> Select a Course</h5>
            <p class="card-subtitle mb-0">Open a course to manage its folders and materials</p>
        </div>
        <form action="{{ route('admin.course-files.index') }}" method="GET" class="cf-filter-bar" id="searchForm">
            <select name="department_id" class="cf-dept-select" onchange="this.form.submit()" aria-label="Filter by department">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" @selected(request('department_id') == $dept->id)>{{ $dept->code ?? $dept->name }}</option>
                @endforeach
            </select>
            <div class="search-box position-relative">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" id="searchInput" placeholder="Search courses, teacher..." value="{{ request('search') }}" style="padding-right: {{ request('search') ? '30px' : '14px' }};">
                @if(request('search'))
                    <button type="button" class="btn-clear-search" onclick="window.location.href='{{ route('admin.course-files.index', array_filter(['department_id' => request('department_id')])) }}'" title="Clear search">
                        <i class="fas fa-times"></i>
        </button>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
            @if(request('search') || request('department_id'))
                <a href="{{ route('admin.course-files.index') }}" class="cf-clear-link" title="Reset filters">
                    <i class="fas fa-rotate-left"></i> Reset
                </a>
            @endif
        </form>
    </div>

    @if($courseLibrary && $courseLibrary->count() > 0)
        <div class="course-lib-grid">
            @foreach($courseLibrary as $course)
            <a href="{{ route('admin.course-files.index', ['course_id' => $course->id]) }}" class="course-lib-card">
                <div class="course-lib-top">
                    <div class="course-lib-icon"><i class="fas fa-book-open"></i></div>
                    <span class="badge dark" style="font-size: 0.7rem;">{{ $course->course_code }}</span>
                </div>
            <div>
                    <h6 class="course-lib-title">{{ $course->title }}</h6>
                    <div class="course-lib-meta">
                        @if($course->teacher)
                            <span><i class="fas fa-chalkboard-teacher"></i> {{ $course->teacher->name }}</span>
                        @else
                            <span><i class="fas fa-user-slash"></i> No teacher assigned</span>
                        @endif
                        @if($course->department)
                            <span>·</span>
                            <span><i class="fas fa-building-columns"></i> {{ $course->department->code ?? $course->department->name }}</span>
                        @endif
                    </div>
                </div>
                <div class="course-lib-stats">
                    <span class="course-lib-stat"><i class="fas fa-file" style="color:var(--primary);"></i> {{ $course->materials_count }} file{{ $course->materials_count !== 1 ? 's' : '' }}</span>
                    <span class="course-lib-stat"><i class="fas fa-folder" style="color:#f59e0b;"></i> {{ $course->folders_count }} folder{{ $course->folders_count !== 1 ? 's' : '' }}</span>
                    <span class="course-lib-open">Open <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            @endforeach
                    </div>
        @if($courseLibrary->hasPages())
            <div class="px-4 pb-4 border-top pt-3">
                {{ $courseLibrary->links('pagination::bootstrap-5') }}
            </div>
        @endif
                @else
        <div class="text-center py-5 px-3">
            <div class="empty-state">
                <i class="fas fa-book-open fa-3x text-muted mb-3" style="opacity: 0.2;"></i>
                @if(request('search') || request('department_id'))
                    <h6 class="text-heading fw-bold">No courses match your filters</h6>
                    <p class="text-muted small">Try a different search or clear filters.</p>
                    <a href="{{ route('admin.course-files.index') }}" class="btn btn-sm btn-primary mt-2">Clear Filters</a>
                @else
                    <h6 class="text-heading fw-bold">No active courses yet</h6>
                    <p class="text-muted small">Create a course first, then add materials here.</p>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-sm btn-primary mt-2">Go to Courses</a>
                @endif
            </div>
        </div>
    @endif
</div>
@endif

{{-- ===================== COURSE FILE BROWSER ===================== --}}
@if($viewMode === 'browser' && $activeCourse)
<div class="data-card">
    <div class="cf-toolbar">
        <div style="min-width: 0;">
            <div class="cf-breadcrumb">
                <a href="{{ route('admin.course-files.index') }}"><i class="fas fa-th-large"></i> All Courses</a>
                <span class="sep">/</span>
                @if($activeFolder)
                    <a href="{{ route('admin.course-files.index', ['course_id' => $activeCourse->id]) }}">{{ $activeCourse->course_code }}</a>
                    @foreach(($folderBreadcrumbs ?? collect()) as $crumb)
                        <span class="sep">/</span>
                        @if($loop->last)
                            <span class="current"><i class="fas fa-folder-open" style="color:#f59e0b;"></i> {{ $crumb->name }}</span>
                        @else
                            <a href="{{ route('admin.course-files.index', ['folder_id' => $crumb->id]) }}">{{ $crumb->name }}</a>
                        @endif
                    @endforeach
                @else
                    <span class="current">{{ $activeCourse->course_code }}</span>
                @endif
            </div>
            <h5 class="card-title mb-0" style="margin-top: 6px;">
                {{ $activeCourse->title }}
            </h5>
            <p class="card-subtitle mb-0" style="margin-top: 2px;">
                @if($activeCourse->teacher)
                    <i class="fas fa-chalkboard-teacher"></i> {{ $activeCourse->teacher->name }}
                @else
                    Unassigned
                @endif
                @if($activeCourse->department)
                    · {{ $activeCourse->department->name }}
                @endif
            </p>
        </div>
        <form action="{{ route('admin.course-files.index') }}" method="GET" class="d-flex align-items-center gap-2">
            <input type="hidden" name="course_id" value="{{ $activeCourse->id }}">
            @if($activeFolder)
                    <input type="hidden" name="folder_id" value="{{ $activeFolder->id }}">
                @endif
                <div class="search-box position-relative">
                    <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" placeholder="Search folders & files..." value="{{ request('search') }}" style="padding-right: 30px;">
                    @if(request('search'))
                    <button type="button" class="btn-clear-search"
                        onclick="window.location.href='{{ route('admin.course-files.index', array_filter(['course_id' => $activeCourse->id, 'folder_id' => $activeFolder->id ?? null])) }}'"
                        title="Clear">
                        <i class="fas fa-times"></i>
                    </button>
                @endif
            </div>
            <button type="submit" class="btn btn-primary" title="Search"><i class="fas fa-search"></i></button>
            @if($activeFolder)
                <a href="{{ route('admin.course-folders.download', $activeFolder->id) }}" class="btn btn-secondary" title="Download this folder as ZIP" style="height:40px; display:inline-flex; align-items:center; gap:6px; text-decoration:none;">
                    <i class="fas fa-file-zipper"></i> Download ZIP
                </a>
            @endif
        </form>
    </div>

    <div class="card-body">
        <div class="table-wrap table-responsive">
            <table class="premium-table w-100">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Uploaded By</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Modified</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Parent link when inside folder --}}
                    @if($activeFolder)
                    @php
                        $backUrl = $activeFolder->parent_id
                            ? route('admin.course-files.index', ['folder_id' => $activeFolder->parent_id])
                            : route('admin.course-files.index', ['course_id' => $activeCourse->id]);
                        $backLabel = $activeFolder->parent_id ? '.. (Back to parent folder)' : '.. (Back to course root)';
                        $backSub = $activeFolder->parent_id ? 'Return to parent folder' : 'Return to folders & root files';
                    @endphp
                    <tr style="cursor:pointer;" onclick="window.location.href='{{ $backUrl }}'">
                        <td colspan="6">
                            <div class="fb-name-cell">
                                <div class="fb-ico folder"><i class="fas fa-level-up-alt"></i></div>
                                <div>
                                    <div class="user-name">{{ $backLabel }}</div>
                                    <div class="user-sub">{{ $backSub }}</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif

                    {{-- Folders --}}
                    @foreach($browserFolders as $folder)
                    <tr class="fb-row-folder" style="cursor:pointer;"
                        onclick="if(!event.target.closest('form,button,a')) window.location.href='{{ route('admin.course-files.index', ['folder_id' => $folder->id]) }}'">
                        <td>
                            <div class="fb-name-cell">
                                <div class="fb-ico folder"><i class="fas fa-folder"></i></div>
                                <div>
                                    <div class="user-name">{{ $folder->name }}</div>
                                    <div class="user-sub">
                                        {{ $folder->materials_count }} file{{ $folder->materials_count !== 1 ? 's' : '' }}
                                        @if(($folder->children_count ?? 0) > 0)
                                            · {{ $folder->children_count }} subfolder{{ $folder->children_count !== 1 ? 's' : '' }}
                                        @endif
                                        · by {{ $folder->creator->name ?? 'Admin' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center"><span class="folder-badge"><i class="fas fa-folder"></i> Folder</span></td>
                        <td class="text-center"><span class="user-sub">{{ $folder->creator->name ?? '—' }}</span></td>
                        <td class="text-center"><span class="user-sub">—</span></td>
                        <td class="text-center"><span class="user-sub">{{ $folder->updated_at?->diffForHumans() }}</span></td>
                        <td>
                            <div class="action-group" onclick="event.stopPropagation();">
                                <a href="{{ route('admin.course-files.index', ['folder_id' => $folder->id]) }}" class="action-btn" style="background-color: var(--primary-light); color: var(--primary);" title="Open">
                                    <i class="fas fa-folder-open"></i>
                                </a>
                                <button type="button" class="action-btn js-edit-folder" title="Rename Folder"
                                    data-bs-toggle="modal" data-bs-target="#editFolderModal"
                                    data-id="{{ $folder->id }}"
                                    data-folder-name="{{ e($folder->name) }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="{{ route('admin.course-folders.destroy', $folder->id) }}" method="POST" class="m-0 p-0 folder-del-form d-flex align-items-center">
                                    @csrf @method('DELETE')
                                    <button type="button" class="action-btn delete folder-delete-btn" title="Delete Folder"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                    {{-- Files --}}
                    @forelse($materials as $material)
                    @php
                        $ext = strtolower($material->file_type ?? 'file');
                        $icon = 'fa-file-alt';
                        $icoClass = 'file';
                        $badgeClass = 'primary';
                        if ($ext === 'pdf') { $icon = 'fa-file-pdf'; $icoClass = 'pdf'; $badgeClass = 'danger'; }
                        elseif (in_array($ext, ['doc', 'docx'])) { $icon = 'fa-file-word'; $icoClass = 'doc'; $badgeClass = 'info'; }
                        elseif (in_array($ext, ['xls', 'xlsx', 'csv'])) { $icon = 'fa-file-excel'; $icoClass = 'xls'; $badgeClass = 'success'; }
                        elseif (in_array($ext, ['ppt', 'pptx'])) { $icon = 'fa-file-powerpoint'; $icoClass = 'ppt'; $badgeClass = 'rose'; }
                        elseif (in_array($ext, ['zip', 'rar', '7z'])) { $icon = 'fa-file-archive'; $icoClass = 'zip'; $badgeClass = 'warning'; }
                        elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'])) { $icon = 'fa-file-image'; $icoClass = 'img'; $badgeClass = 'cyan'; }
                        $size = $material->file_size ?? 0;
                        $sizeLabel = $size < 1024 ? $size . ' B' : ($size < 1048576 ? round($size / 1024, 1) . ' KB' : round($size / 1048576, 2) . ' MB');
                    @endphp
                    <tr>
                        <td>
                            <div class="fb-name-cell">
                                <div class="fb-ico {{ $icoClass }}"><i class="fas {{ $icon }}"></i></div>
                                <div>
                                    <div class="user-name">{{ $material->title }}</div>
                                    <div class="user-sub">Uploaded {{ $material->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.course-files.download', $material->id) }}" target="_blank" class="badge {{ $badgeClass }}" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                                <i class="fas {{ $icon }}"></i> {{ strtoupper($ext) }}
                            </a>
                        </td>
                        <td class="text-center">
                            <div class="user-name" style="font-size:0.82rem;">{{ $material->uploader->name ?? 'Unknown' }}</div>
                        </td>
                        <td class="text-center"><span class="user-sub">{{ $sizeLabel }}</span></td>
                        <td class="text-center"><span class="user-sub">{{ $material->updated_at->format('d M Y') }}</span></td>
                        <td>
                            <div class="action-group">
                                @if(in_array($ext, ['pdf', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp']))
                                <button type="button" class="action-btn" style="background-color: var(--primary-light); color: var(--primary);"
                                    onclick="openPreviewModal('{{ route('admin.course-files.preview', $material->id) }}', '{{ addslashes($material->title) }}', '{{ $ext }}')" title="Preview">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @endif
                                <a href="{{ route('admin.course-files.download', $material->id) }}" class="action-btn" style="background:#ecfdf5; color:#059669;" title="Download" target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>
                                <button class="action-btn edit edit-btn" data-bs-toggle="modal" data-bs-target="#editFileModal"
                                    data-id="{{ $material->id }}"
                                    data-course="{{ $material->course_id }}"
                                    data-title="{{ $material->title }}"
                                    data-filepath="{{ $material->file_path }}"
                                    data-fileext="{{ strtoupper($ext) }}"
                                    data-teacherid="{{ $material->uploaded_by }}"
                                    data-folderid="{{ $material->folder_id ?? '' }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="{{ route('admin.course-files.destroy', $material->id) }}" method="POST" class="m-0 p-0 delete-form d-flex align-items-center">
                                    @csrf @method('DELETE')
                                    <button type="button" class="action-btn delete delete-btn"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                        @if(request('search') && $browserFolders->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-search fa-3x text-muted mb-3" style="opacity: 0.2;"></i>
                                    <h6 class="text-heading fw-bold">No folders or files match “{{ request('search') }}”</h6>
                                    <p class="text-muted small">Try another keyword or clear search.</p>
                                </div>
                            </td>
                        </tr>
                        @elseif(!request('search') && $browserFolders->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-folder-open fa-3x text-muted mb-3" style="opacity: 0.2;"></i>
                                    @if($activeFolder)
                                        <h6 class="text-heading fw-bold">This folder is empty</h6>
                                        <p class="text-muted small">Create a subfolder or upload a material here.</p>
                                        <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
                                            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#createFolderModal"
                                                onclick="prefillFolderCourse({{ $activeCourse->id }}, {{ $activeFolder->id }}, @js($activeFolder->name))">
                                                <i class="fas fa-folder-plus"></i> New Folder
                                            </button>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal"
                                                onclick="prefillUploadContext({{ $activeCourse->id }}, {{ $activeFolder->id }})">
                                                <i class="fas fa-cloud-upload-alt"></i> Upload Here
                                            </button>
                                        </div>
                                    @else
                                        <h6 class="text-heading fw-bold">No materials in this course yet</h6>
                                        <p class="text-muted small">Create a folder or upload files directly to the course root.</p>
                                        <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
                                            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#createFolderModal"
                                                onclick="prefillFolderCourse({{ $activeCourse->id }}, null, null)">
                                                <i class="fas fa-folder-plus"></i> New Folder
                                            </button>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal"
                                                onclick="prefillUploadContext({{ $activeCourse->id }}, null)">
                                                <i class="fas fa-cloud-upload-alt"></i> Upload Material
                                            </button>
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
            <div class="mt-3 px-3 pb-3 border-top pt-3">
                {{ $materials->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endif

{{-- ===================== ALL FILES (flat list) ===================== --}}
@if($viewMode === 'all_files')
<div class="data-card">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5 class="card-title"><i class="fas fa-table-list"></i> All Uploaded Files</h5>
            <p class="card-subtitle">Complete list across every course</p>
        </div>
        <form action="{{ route('admin.course-files.index') }}" method="GET" class="d-flex align-items-center gap-2">
            <input type="hidden" name="view" value="all">
            <div class="search-box position-relative">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" placeholder="Search any field..." value="{{ request('search') }}" style="padding-right: 30px;">
                @if(request('search'))
                    <button type="button" class="btn-clear-search" onclick="window.location.href='{{ route('admin.course-files.index', ['view' => 'all']) }}'" title="Clear">
                            <i class="fas fa-times"></i>
                        </button>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem;"><i class="fas fa-search"></i> Search</button>
            </form>
        </div>
        <div class="card-body">
            <div class="table-wrap table-responsive">
                <table class="premium-table w-100">
                    <thead>
                        <tr>
                            <th>Teacher</th>
                            <th class="text-center">Course</th>
                            <th>Title</th>
                            <th class="text-center">Folder</th>
                            <th class="text-center">File</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($materials as $material)
                    @php
                        $ext = strtolower($material->file_type ?? 'pdf');
                        $icon = 'fa-file-alt';
                        $badgeClass = 'primary';
                        if ($ext === 'pdf') { $icon = 'fa-file-pdf'; $badgeClass = 'danger'; }
                        elseif (in_array($ext, ['doc', 'docx'])) { $icon = 'fa-file-word'; $badgeClass = 'info'; }
                        elseif (in_array($ext, ['xls', 'xlsx', 'csv'])) { $icon = 'fa-file-excel'; $badgeClass = 'success'; }
                        elseif (in_array($ext, ['ppt', 'pptx'])) { $icon = 'fa-file-powerpoint'; $badgeClass = 'rose'; }
                        elseif (in_array($ext, ['zip', 'rar', '7z'])) { $icon = 'fa-file-archive'; $badgeClass = 'warning'; }
                        elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) { $icon = 'fa-file-image'; $badgeClass = 'cyan'; }
                                        $uploaderName = $material->uploader->name ?? 'Unknown';
                                        $initials = strtoupper(substr($uploaderName, 0, 2));
                                        $colors = ['emerald', 'cyan', 'rose', 'blue', 'amber', 'purple', 'indigo'];
                                        $colorClass = $colors[strlen($uploaderName) % count($colors)];
                                    @endphp
                    <tr>
                        <td>
                            <div class="user-cell">
                                    <div class="avatar-sm {{ $colorClass }}">{{ $initials }}</div>
                                    <div>
                                        <div class="user-name">{{ $uploaderName }}</div>
                                        <div class="user-sub">{{ $material->uploader->role ?? 'User' }}</div>
                                    </div>
                                </div>
                            </td>
                        <td class="text-center">
                            <a href="{{ route('admin.course-files.index', ['course_id' => $material->course_id]) }}" class="badge dark" style="text-decoration:none;" title="Open course">
                                {{ $material->course->course_code ?? 'N/A' }}
                            </a>
                        </td>
                            <td>
                                <div class="user-name">{{ $material->title }}</div>
                                <div class="user-sub">Uploaded {{ $material->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="text-center">
                                @if($material->folder)
                                <a href="{{ route('admin.course-files.index', ['folder_id' => $material->folder_id]) }}" class="folder-badge" style="text-decoration:none;">
                                    <i class="fas fa-folder" style="color:#f59e0b; margin-right:4px;"></i>{{ Str::limit($material->folder->name, 14) }}
                                </a>
                                @else
                                    <span style="font-size:0.75rem; color: var(--text-secondary);">— Root —</span>
                                @endif
                            </td>
                            <td class="text-center">
                            <a href="{{ route('admin.course-files.download', $material->id) }}" target="_blank" class="badge {{ $badgeClass }}" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                                    <i class="fas {{ $icon }}"></i> {{ strtoupper($ext) }}
                                </a>
                            </td>
                            <td>
                                <div class="action-group">
                                    @if(in_array($ext, ['pdf', 'png', 'jpg', 'jpeg', 'gif', 'svg']))
                                <button type="button" class="action-btn" style="background-color: var(--primary-light); color: var(--primary);"
                                    onclick="openPreviewModal('{{ route('admin.course-files.preview', $material->id) }}', '{{ addslashes($material->title) }}', '{{ $ext }}')" title="Preview">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @endif
                                    <button class="action-btn edit edit-btn" data-bs-toggle="modal" data-bs-target="#editFileModal"
                                        data-id="{{ $material->id }}"
                                        data-course="{{ $material->course_id }}"
                                        data-title="{{ $material->title }}"
                                        data-filepath="{{ $material->file_path }}"
                                        data-fileext="{{ strtoupper($ext) }}"
                                        data-teacherid="{{ $material->uploaded_by }}"
                                        data-folderid="{{ $material->folder_id ?? '' }}">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <form action="{{ route('admin.course-files.destroy', $material->id) }}" method="POST" class="m-0 p-0 delete-form d-flex align-items-center">
                                    @csrf @method('DELETE')
                                        <button type="button" class="action-btn delete delete-btn"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-folder-open fa-3x text-muted mb-3" style="opacity: 0.2;"></i>
                                    <h6 class="text-heading fw-bold">No Course Files found</h6>
                                    <p class="text-muted small">Upload your first material to get started.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @if($materials && $materials->hasPages())
                <div class="mt-3 px-3 pb-3 border-top pt-3">
                    {{ $materials->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
        </div>
        @endif
@endsection

@push('modals')
<!-- UPLOAD -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content premium">
            <div class="modal-head gradient">
                <h5 class="modal-title"><i class="fas fa-cloud-upload-alt"></i> Upload Material</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <div class="upload-steps">
                    <div class="step"><span style="display:block;margin-bottom:4px;color:var(--primary);">1</span> Choose Course</div>
                    <div class="step"><span style="display:block;margin-bottom:4px;color:var(--primary);">2</span> Folder (optional)</div>
                    <div class="step"><span style="display:block;margin-bottom:4px;color:var(--primary);">3</span> Title &amp; File</div>
                </div>
                <form action="{{ route('admin.course-files.store') }}" method="POST" enctype="multipart/form-data" id="uploadMaterialForm">
                    @csrf
                        <div class="form-group">
                        <label class="form-label">Course <span class="text-danger">*</span></label>
                            <select name="course_id" id="add_course" class="form-select" required placeholder="Select Course">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                <option value="{{ $course->id }}" data-teacher="{{ $course->teacher_id }}">{{ $course->course_code }} — {{ $course->title }}</option>
                                @endforeach
                            </select>
                        <small style="color:var(--text-muted); font-size:0.75rem; margin-top:4px; display:block;">File will be attached to this course only.</small>
                        </div>
                    <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Folder <small style="color:var(--text-secondary); font-weight:400;">(Optional)</small></label>
                        <select name="folder_id" id="add_folder_id" class="form-input" style="padding: 9px 13px; border-radius: var(--radius-md);">
                                <option value="">Root (No Folder)</option>
                        </select>
                    </div>
                    <div class="form-group">
                            <label class="form-label">Uploaded By</label>
                            <select name="uploaded_by" id="add_teacher" class="form-select" placeholder="Select Faculty">
                                <option value="">Auto (course teacher)</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Material Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-input" placeholder="e.g. Lecture 01 — Introduction" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Choose File <span class="text-danger">*</span></label>
                        <div class="upload-zone position-relative" id="upload_zone_container">
                            <div id="upload_default_ui">
                                <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                <p>Drag &amp; drop your file here, or <span class="browse-link">browse</span></p>
                                <small style="color:var(--text-muted); font-size:0.72rem;">PDF, DOC, PPT, ZIP, images — Max 20 MB</small>
                            </div>
                            <div id="upload_file_preview" style="display: none; padding: 10px; text-align: center;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                    <div style="font-size: 2.5rem; color: var(--primary);"><i class="fas fa-file-alt" id="preview_file_icon"></i></div>
                                    <div style="font-weight: 600; color: var(--text-heading); font-size: 0.95rem; word-break: break-all;" id="preview_file_name">filename.ext</div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);" id="preview_file_size">0 MB</div>
                                    <button type="button" class="btn btn-sm" id="btn_remove_file" style="margin-top: 8px; background: var(--danger-light); color: var(--danger); border-radius: 6px; padding: 6px 14px; font-size: 0.8rem; border: none; cursor: pointer; position: relative; z-index: 20; display: inline-flex; align-items: center; gap: 6px; font-weight: 600;">
                                        <i class="fas fa-times"></i> Remove File
                                    </button>
                                </div>
                            </div>
                            <input type="file" id="upload_file_input" name="file" class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" required style="z-index:10; cursor:pointer;">
                        </div>
                    </div>
                    <div style="display:flex; justify-content:center; gap:12px; margin-top:24px;">
                        <button type="button" class="btn btn-light" style="padding:10px 32px; font-weight:600; border: 1px solid #cbd5e1; background-color: #f1f5f9; color: #334155; box-shadow: 0 2px 4px rgba(0,0,0,0.05);" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary" style="padding:10px 48px;"><i class="fas fa-check-circle"></i> Confirm Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- CREATE FOLDER -->
<div class="modal fade" id="createFolderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
        <div class="modal-content premium">
            <div class="modal-head gradient">
                <h5 class="modal-title"><i class="fas fa-folder-plus"></i> Create New Folder</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <p style="font-size: 0.85rem; color: var(--text-secondary); margin: 0 0 18px; line-height: 1.5;" id="createFolderHint">
                    Folders belong to one course. You can create nested folders inside another folder.
                </p>
                <form action="{{ route('admin.course-folders.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_id" id="modal_create_parent" value="">
                    <div class="form-group">
                        <label class="form-label">Course <span class="text-danger">*</span></label>
                        <select name="course_id" id="modal_create_course" class="form-select" required placeholder="Select Course">
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_code }} — {{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="createFolderParentRow" style="display:none;">
                        <label class="form-label">Parent Folder</label>
                        <input type="text" class="form-input" id="modal_create_parent_label" readonly style="background:#f8fafc;">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Folder Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-input" placeholder="e.g. Lecture Notes, Week 1, Assignments..." required maxlength="100">
                    </div>
                    <div style="display:flex; justify-content:center; gap:12px; margin-top:24px;">
                        <button type="button" class="btn btn-light" style="padding:10px 32px; font-weight:600; border: 1px solid #cbd5e1; background-color: #f1f5f9; color: #334155;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" style="padding:10px 32px;"><i class="fas fa-folder-plus"></i> Create Folder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT FOLDER -->
<div class="modal fade" id="editFolderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
        <div class="modal-content premium">
            <div class="modal-head dark-grad">
                <h5 class="modal-title"><i class="fas fa-pen"></i> Rename Folder</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <form id="editFolderForm" method="POST" action="#">
                    @csrf @method('PUT')
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Folder Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_folder_name" class="form-input" required maxlength="100">
                    </div>
                    <div style="display:flex; justify-content:center; gap:12px; margin-top:24px;">
                        <button type="button" class="btn btn-light" style="padding:10px 32px; font-weight:600; border: 1px solid #cbd5e1; background-color: #f1f5f9; color: #334155;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" style="padding:10px 32px;"><i class="fas fa-check"></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT FILE -->
<div class="modal fade" id="editFileModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content premium">
            <div class="modal-head dark-grad">
                <h5 class="modal-title"><i class="fas fa-pen"></i> Update Material</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <form id="editFileForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                        <div class="form-group">
                        <label class="form-label">Course <span class="text-danger">*</span></label>
                            <select name="course_id" id="edit_course_id" class="form-select" required placeholder="Select Course">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                <option value="{{ $course->id }}" data-teacher="{{ $course->teacher_id }}">{{ $course->course_code }} — {{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Folder <small style="color:var(--text-secondary); font-weight:400;">(Optional)</small></label>
                        <select name="folder_id" id="edit_folder_id" class="form-input" style="padding: 9px 13px; border-radius: var(--radius-md);">
                                <option value="">Root (No Folder)</option>
                        </select>
                    </div>
                    <div class="form-group">
                            <label class="form-label">Uploaded By</label>
                            <select name="uploaded_by" id="edit_teacher_id" class="form-select" placeholder="Select Faculty">
                                <option value="">Select Faculty</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="edit_title" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Replace File</label>
                        <div class="file-info-bar mb-2">
                            <i class="fas fa-file-alt" id="edit_file_icon"></i> Current: <span id="edit_file_name"></span>
                        </div>
                        <input type="file" name="file" class="form-input" style="padding:8px;">
                        <small style="color:var(--text-muted);font-size:0.75rem;margin-top:4px;display:block;">Leave empty if you don't want to change the file.</small>
                    </div>
                    <div style="display:flex; justify-content:center; gap:12px; margin-top:24px;">
                        <button type="button" class="btn btn-light" style="padding:10px 32px; font-weight:600; border: 1px solid #cbd5e1; background-color: #f1f5f9; color: #334155;" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary" style="padding:10px 48px;"><i class="fas fa-check-circle"></i> Update Material</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content premium">
            <div class="modal-head gradient">
                <h5 class="modal-title" id="previewModalLabel"><i class="fas fa-eye"></i> File Preview</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body p-0" style="height: 80vh; background-color: #f8f9fa; position: relative;">
                <div id="iframeLoader" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"><span class="visually-hidden">Loading...</span></div>
                </div>
                <iframe id="previewIframe" src="" style="width: 100%; height: 100%; border: none; position: relative; z-index: 2; background: transparent;"></iframe>
                <img id="previewImage" src="" style="width: 100%; height: 100%; object-fit: contain; position: relative; z-index: 2; display: none; margin: auto;" alt="Preview">
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function openPreviewModal(url, title, ext) {
        document.getElementById('previewModalLabel').innerHTML = '<i class="fas fa-eye"></i> ' + title;
        document.getElementById('iframeLoader').style.display = 'block';
        const isImage = ['png', 'jpg', 'jpeg', 'gif', 'svg', 'webp'].includes(ext ? ext.toLowerCase() : '');
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

    document.getElementById('previewModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('previewIframe').src = '';
        document.getElementById('previewImage').src = '';
        document.getElementById('iframeLoader').style.display = 'none';
    });

    function loadAdminFolders(courseId, selectId, selectedFolderId) {
        const select = document.getElementById(selectId);
        if (!select) return;
        
        const ts = select.tomselect;
        if (ts) {
            ts.clearOptions();
            ts.addOption({ value: '', text: 'Root (No Folder)' });
            if (courseId) {
                const courseFolders = adminAllFolders[courseId] || [];
                courseFolders.forEach(function(folder) {
                    ts.addOption({ value: String(folder.id), text: folder.label || folder.name });
                });
            }
            ts.refreshOptions(false);
            ts.setValue(selectedFolderId ? String(selectedFolderId) : '');
        } else {
            select.innerHTML = '<option value="">Root (No Folder)</option>';
            if (!courseId) return;
            const courseFolders = adminAllFolders[courseId] || [];
            courseFolders.forEach(function(folder) {
                const opt = document.createElement('option');
                opt.value = folder.id;
                opt.textContent = folder.label || folder.name;
                select.appendChild(opt);
            });
            if (selectedFolderId) select.value = selectedFolderId;
        }
    }

    function setTeacherFromCourse(courseId, teacherSelectId) {
        const course = (adminCoursesData || []).find(c => String(c.id) === String(courseId));
        const select = document.getElementById(teacherSelectId);
        if (!select || !course || !course.teacher_id) return;
        if (select.tomselect) {
            select.tomselect.setValue(String(course.teacher_id));
        } else {
            select.value = course.teacher_id;
        }
    }

    function prefillUploadContext(courseId, folderId) {
        setTimeout(function() {
            const courseSelect = document.getElementById('add_course');
            if (courseSelect && courseSelect.tomselect) {
                courseSelect.tomselect.setValue(String(courseId));
            } else if (courseSelect) {
                courseSelect.value = courseId;
                loadAdminFolders(courseId, 'add_folder_id', folderId);
                setTeacherFromCourse(courseId, 'add_teacher');
            }
            setTimeout(function() {
                loadAdminFolders(courseId, 'add_folder_id', folderId);
                setTeacherFromCourse(courseId, 'add_teacher');
            }, 80);
        }, 150);
    }

    function prefillFolderCourse(courseId, parentId, parentName) {
        setTimeout(function() {
            const sel = document.getElementById('modal_create_course');
            if (sel && sel.tomselect) sel.tomselect.setValue(String(courseId));
            else if (sel) sel.value = courseId;

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

    const ADMIN_FOLDER_BASE = @json(url('/admin/course-folders'));

    function populateEditFolderModal(id, name) {
        const form = document.getElementById('editFolderForm');
        const nameInput = document.getElementById('edit_folder_name');
        if (!form || !nameInput || !id) return;
        form.action = ADMIN_FOLDER_BASE + '/' + id;
        nameInput.value = name || '';
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tsConfig = {
            create: false,
            controlInput: null,
            maxOptions: null,
            allowEmptyOption: true,
            wrapperClass: 'ts-wrapper form-select ts-faculty',
            plugins: ['dropdown_input'],
            sortField: { field: 'text', direction: 'asc' }
        };
        const tsConfigCourse = { ...tsConfig, wrapperClass: 'ts-wrapper form-select ts-course' };
        const tsConfigFolder = { ...tsConfig, wrapperClass: 'ts-wrapper form-select ts-folder' };

        if (document.getElementById('add_teacher')) {
            let addT = new TomSelect('#add_teacher', tsConfig);
            let si = addT.dropdown.querySelector('input');
            if (si) si.setAttribute('placeholder', 'Search faculty...');
        }
        if (document.getElementById('edit_teacher_id')) {
            window.editTeacherSelect = new TomSelect('#edit_teacher_id', tsConfig);
            let si = window.editTeacherSelect.dropdown.querySelector('input');
            if (si) si.setAttribute('placeholder', 'Search faculty...');
        }
        if (document.getElementById('add_course')) {
            let addC = new TomSelect('#add_course', tsConfigCourse);
            let si = addC.dropdown.querySelector('input');
            if (si) si.setAttribute('placeholder', 'Search course...');
            addC.on('change', function(val) {
                loadAdminFolders(val, 'add_folder_id');
                setTeacherFromCourse(val, 'add_teacher');
            });
        }
        if (document.getElementById('edit_course_id')) {
            window.editCourseSelect = new TomSelect('#edit_course_id', tsConfigCourse);
            let si = window.editCourseSelect.dropdown.querySelector('input');
            if (si) si.setAttribute('placeholder', 'Search course...');
            window.editCourseSelect.on('change', function(val) {
                loadAdminFolders(val, 'edit_folder_id');
            });
        }
        if (document.getElementById('add_folder_id')) {
            let ts = new TomSelect('#add_folder_id', tsConfigFolder);
            let si = ts.dropdown.querySelector('input');
            if (si) si.setAttribute('placeholder', 'Search folder...');
        }
        if (document.getElementById('edit_folder_id')) {
            let ts = new TomSelect('#edit_folder_id', tsConfigFolder);
            let si = ts.dropdown.querySelector('input');
            if (si) si.setAttribute('placeholder', 'Search folder...');
        }
        if (document.getElementById('modal_create_course')) {
            let modalCreateCourse = new TomSelect('#modal_create_course', tsConfigCourse);
            let si = modalCreateCourse.dropdown.querySelector('input');
            if (si) si.setAttribute('placeholder', 'Search course...');
        }

        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('edit_title').value = this.getAttribute('data-title');
                const courseId = this.getAttribute('data-course');
                const folderId = this.getAttribute('data-folderid');

                if (window.editTeacherSelect) window.editTeacherSelect.setValue(this.getAttribute('data-teacherid'));
                if (window.editCourseSelect) window.editCourseSelect.setValue(courseId);

                loadAdminFolders(courseId, 'edit_folder_id', folderId);

                let filePath = this.getAttribute('data-filepath');
                document.getElementById('edit_file_name').innerText = filePath ? filePath.split('/').pop() : 'No file';

                let ext = this.getAttribute('data-fileext');
                let iconClass = 'fa-file-alt';
                if (ext === 'PDF') iconClass = 'fa-file-pdf';
                else if (ext === 'DOC' || ext === 'DOCX') iconClass = 'fa-file-word';
                else if (ext === 'XLS' || ext === 'XLSX') iconClass = 'fa-file-excel';
                else if (ext === 'PPT' || ext === 'PPTX') iconClass = 'fa-file-powerpoint';
                else if (ext === 'ZIP' || ext === 'RAR') iconClass = 'fa-file-archive';
                document.getElementById('edit_file_icon').className = 'fas ' + iconClass;

                document.getElementById('editFileForm').action = "{{ route('admin.course-files.update', ':id') }}".replace(':id', id);
            });
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This file will be permanently deleted!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => { if (result.isConfirmed) form.submit(); });
            });
        });

        document.querySelectorAll('.folder-delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Delete Folder?',
                    html: 'Files inside will be moved to <b>root</b>. The folder cannot be recovered.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Yes, delete!'
                }).then((result) => { if (result.isConfirmed) form.submit(); });
            });
        });

        const fileInput = document.getElementById('upload_file_input');
        const defaultUI = document.getElementById('upload_default_ui');
        const previewUI = document.getElementById('upload_file_preview');
        const previewName = document.getElementById('preview_file_name');
        const previewSize = document.getElementById('preview_file_size');
        const previewIcon = document.getElementById('preview_file_icon');
        const removeBtn = document.getElementById('btn_remove_file');

        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    const file = this.files[0];
                    previewName.textContent = file.name;
                    let size = file.size;
                    previewSize.textContent = size < 1024 ? size + ' B' : size < 1048576 ? (size / 1024).toFixed(1) + ' KB' : (size / 1048576).toFixed(2) + ' MB';
                    const ext = file.name.split('.').pop().toLowerCase();
                    let iconClass = 'fa-file-alt';
                    if (['pdf'].includes(ext)) iconClass = 'fa-file-pdf';
                    else if (['doc', 'docx'].includes(ext)) iconClass = 'fa-file-word';
                    else if (['xls', 'xlsx', 'csv'].includes(ext)) iconClass = 'fa-file-excel';
                    else if (['ppt', 'pptx'].includes(ext)) iconClass = 'fa-file-powerpoint';
                    else if (['zip', 'rar', '7z'].includes(ext)) iconClass = 'fa-file-archive';
                    else if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) iconClass = 'fa-file-image';
                    previewIcon.className = 'fas ' + iconClass;
                    defaultUI.style.display = 'none';
                    previewUI.style.display = 'block';
                    fileInput.style.zIndex = '5';
                } else {
                    defaultUI.style.display = 'block';
                    previewUI.style.display = 'none';
                    fileInput.style.zIndex = '10';
                }
            });
            removeBtn.addEventListener('click', function(e) {
                e.preventDefault(); e.stopPropagation();
                fileInput.value = '';
                fileInput.dispatchEvent(new Event('change'));
            });
        }

        @if($activeCourse)
            // Prefill modals when opened from browser context
            document.getElementById('uploadModal')?.addEventListener('show.bs.modal', function() {
                prefillUploadContext({{ $activeCourse->id }}, {{ $activeFolder->id ?? 'null' }});
            });
            document.getElementById('createFolderModal')?.addEventListener('show.bs.modal', function() {
                prefillFolderCourse({{ $activeCourse->id }}, {{ $activeFolder->id ?? 'null' }}, @js($activeFolder?->name));
            });
        @endif

        const editFolderModal = document.getElementById('editFolderModal');
        if (editFolderModal) {
            editFolderModal.addEventListener('show.bs.modal', function(ev) {
                const btn = ev.relatedTarget && ev.relatedTarget.closest
                    ? (ev.relatedTarget.closest('.js-edit-folder') || ev.relatedTarget)
                    : ev.relatedTarget;
                if (btn && btn.classList && btn.classList.contains('js-edit-folder')) {
                    populateEditFolderModal(btn.dataset.id, btn.dataset.folderName);
                }
            });
        }

        document.addEventListener('click', function(e) {
            const editFolderBtn = e.target.closest('.js-edit-folder');
            if (editFolderBtn) {
                populateEditFolderModal(editFolderBtn.dataset.id, editFolderBtn.dataset.folderName);
            }
        });
    });
</script>
@endpush
