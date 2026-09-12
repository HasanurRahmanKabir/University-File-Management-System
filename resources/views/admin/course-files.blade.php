@extends('layouts.admin')
@section('title', 'Course Files - Admin Dashboard')
@section('page-title', 'Course Materials')
@section('breadcrumb', 'Course Files')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
    /* TomSelect */
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
    
    /* Fix for TomSelect dropdown growing large when cleared */
    .ts-wrapper.form-select .ts-control { flex-wrap: nowrap !important; overflow: hidden !important; }
    .ts-wrapper.form-select .ts-control > input { width: 0 !important; min-width: 0 !important; padding: 0 !important; margin: 0 !important; border: none !important; opacity: 0 !important; }

    /* Tab nav */
    .cf-nav { display: flex; gap: 8px; border-bottom: 2px solid var(--border-light); margin-bottom: 0; padding: 0 24px; }
    .cf-nav .cf-tab { padding: 12px 20px; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); border: none; background: transparent; cursor: pointer; border-bottom: 2px solid transparent; margin-bottom: -2px; display: flex; align-items: center; gap: 7px; transition: all 0.2s; border-radius: var(--radius-sm) var(--radius-sm) 0 0; }
    .cf-nav .cf-tab:hover { color: var(--text-heading); background: var(--bg-muted); }
    .cf-nav .cf-tab.active { color: var(--primary); border-bottom-color: var(--primary); background: var(--primary-light); }
    .cf-tab-content { padding: 0; }
    .cf-pane { display: none; }
    .cf-pane.active { display: block; }

    /* Folder Grid */
    .folder-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 14px; padding: 24px; }
    .folder-card { background: var(--bg-card); border: 2px solid var(--border-light); border-radius: var(--radius-lg); padding: 18px 16px; cursor: pointer; display: flex; flex-direction: column; gap: 10px; transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); position: relative; overflow: hidden; margin-top: 4px; margin-bottom: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .folder-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #f59e0b, #f97316); opacity: 1; }
    .folder-card:hover { box-shadow: 0 14px 24px -6px rgba(245, 158, 11, 0.2), 0 8px 12px -4px rgba(245, 158, 11, 0.1); transform: translateY(-8px) scale(1.02); border-color: #f59e0b; }
    .folder-ico { font-size: 2.4rem; color: #f59e0b; line-height: 1; }
    .folder-name { font-size: 0.85rem; font-weight: 700; color: var(--text-heading); word-break: break-word; }
    .folder-meta { font-size: 0.75rem; color: var(--text-secondary); display: flex; align-items: center; gap: 5px; }

    /* Create folder inline form */
    .create-folder-bar { display: flex; align-items: center; gap: 10px; padding: 16px 24px; border-bottom: 1px solid var(--border-light); background: var(--bg-muted); flex-wrap: wrap; }
    .create-folder-bar .form-input { height: 38px; font-size: 0.85rem; }
    .create-folder-bar .form-select { height: 38px; font-size: 0.85rem; min-width: 180px; }
    .create-folder-bar .btn { padding: 8px 18px; font-size: 0.85rem; height: 38px; }

    /* Table folder badge */
    .folder-badge { background: var(--warning-light, #fffbeb); color: #92400e; border-radius: 5px; padding: 2px 8px; font-size: 0.72rem; font-weight: 700; }
</style>
@endpush

@section('content')
<div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div class="heading-group">
        <h2>Uploaded Course Materials</h2>
        <p>View and manage all course files uploaded by faculty members.</p>
    </div>
    <div style="display:flex; gap:8px; margin-right: 15px;">
        <button class="btn btn-secondary mt-2 mt-sm-0" data-bs-toggle="modal" data-bs-target="#createFolderModal">
            <i class="fas fa-folder-plus"></i> New Folder
        </button>
        <button class="btn btn-primary mt-2 mt-sm-0" data-bs-toggle="modal" data-bs-target="#uploadModal">
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

{{-- Folders JSON for JS --}}
<script>const adminAllFolders = @json($allFolders);</script>

<div class="data-card">
    {{-- Tab Nav --}}
    <div class="cf-nav" role="tablist">
        <button class="cf-tab active" id="tab-files" onclick="switchTab('files')" role="tab" aria-selected="true">
            <i class="fas fa-table-list"></i> All Files
        </button>
        <button class="cf-tab" id="tab-folders" onclick="switchTab('folders')" role="tab" aria-selected="false">
            <i class="fas fa-folder-open"></i> Folder View
            <span class="badge dark" style="font-size:0.65rem; padding: 2px 8px; border-radius:30px;">{{ $allFolders->flatten()->count() }}</span>
        </button>
    </div>

    {{-- ===== PANE: ALL FILES ===== --}}
    <div class="cf-pane active" id="pane-files">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3" style="padding: 16px 24px; border-bottom: 1px solid var(--border-light);">
            <div>
                @if(isset($activeFolder) && $activeFolder)
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 4px;">
                        <a href="{{ route('admin.course-files.index') }}" class="btn btn-sm" style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; font-weight: 600; color: var(--text-heading); background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; padding: 6px 14px; text-decoration: none; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" onmouseover="this.style.background='#e2e8f0'; this.style.borderColor='#94a3b8'; this.style.transform='translateX(-2px)';" onmouseout="this.style.background='#f1f5f9'; this.style.borderColor='#cbd5e1'; this.style.transform='translateX(0)';">
                            <i class="fas fa-arrow-left"></i> Back to Folders
                        </a>
                        <h5 class="card-title mb-0" style="display: flex; align-items: center; gap: 8px; font-size: 1.25rem;">
                            <i class="fas fa-folder-open" style="color:#f59e0b;"></i> {{ $activeFolder->name }}
                        </h5>
                    </div>
                    <p class="card-subtitle" style="margin-top: 6px;">Viewing files inside this folder</p>
                @else
                    <h5 class="card-title"><i class="fas fa-folder-open"></i> Teacher's Uploaded Files</h5>
                    <p class="card-subtitle">All course materials with file types</p>
                @endif
            </div>
            <form action="{{ route('admin.course-files.index') }}" method="GET" class="d-flex align-items-center gap-2" id="searchForm">
                @if(isset($activeFolder) && $activeFolder)
                    <input type="hidden" name="folder_id" value="{{ $activeFolder->id }}">
                @endif
                <div class="search-box position-relative">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="search" id="searchInput" placeholder="Search any field..." value="{{ request('search') }}" style="padding-right: 30px;">
                    @if(request('search'))
                        <button type="button" class="btn-clear-search" onclick="window.location.href='{{ route('admin.course-files.index') }}'" title="Clear Search">
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
                        <tr>
                            <td>
                                <div class="user-cell">
                                    @php
                                        $uploaderName = $material->uploader->name ?? 'Unknown';
                                        $initials = strtoupper(substr($uploaderName, 0, 2));
                                        $colors = ['emerald', 'cyan', 'rose', 'blue', 'amber', 'purple', 'indigo'];
                                        $colorClass = $colors[strlen($uploaderName) % count($colors)];
                                    @endphp
                                    <div class="avatar-sm {{ $colorClass }}">{{ $initials }}</div>
                                    <div>
                                        <div class="user-name">{{ $uploaderName }}</div>
                                        <div class="user-sub">{{ $material->uploader->role ?? 'User' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center"><span class="badge dark">{{ $material->course->course_code ?? 'N/A' }}</span></td>
                            <td>
                                <div class="user-name">{{ $material->title }}</div>
                                <div class="user-sub">Uploaded {{ $material->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="text-center">
                                @if($material->folder)
                                    <span class="folder-badge"><i class="fas fa-folder" style="color:#f59e0b; margin-right:4px;"></i>{{ Str::limit($material->folder->name, 14) }}</span>
                                @else
                                    <span style="font-size:0.75rem; color: var(--text-secondary);">— Root —</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @php
                                    $ext = strtolower($material->file_type ?? 'pdf');
                                    $icon = 'fa-file-alt';
                                    $badgeClass = 'primary';
                                    if (in_array($ext, ['pdf'])) { $icon = 'fa-file-pdf'; $badgeClass = 'danger'; }
                                    elseif (in_array($ext, ['doc', 'docx'])) { $icon = 'fa-file-word'; $badgeClass = 'info'; }
                                    elseif (in_array($ext, ['xls', 'xlsx', 'csv'])) { $icon = 'fa-file-excel'; $badgeClass = 'success'; }
                                    elseif (in_array($ext, ['ppt', 'pptx'])) { $icon = 'fa-file-powerpoint'; $badgeClass = 'rose'; }
                                    elseif (in_array($ext, ['zip', 'rar', '7z'])) { $icon = 'fa-file-archive'; $badgeClass = 'warning'; }
                                    elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) { $icon = 'fa-file-image'; $badgeClass = 'cyan'; }
                                @endphp
                                <a href="{{ route('admin.course-files.download', $material->id) }}" target="_blank" class="badge {{ $badgeClass }}" style="text-decoration: none; display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; font-size: 0.75rem; border-radius: var(--radius-sm); transition: all 0.2s;">
                                    <i class="fas {{ $icon }}"></i> {{ strtoupper($ext) }}
                                </a>
                            </td>
                            <td>
                                <div class="action-group">
                                    @if(in_array($ext, ['pdf', 'png', 'jpg', 'jpeg', 'gif', 'svg']))
                                    <button type="button" class="action-btn" style="background-color: var(--primary-light); color: var(--primary);" onclick="openPreviewModal('{{ route('admin.course-files.preview', $material->id) }}', '{{ addslashes($material->title) }}', '{{ $ext }}')" title="Preview">
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
                                        @csrf
                                        @method('DELETE')
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
            @if($materials->hasPages())
                <div class="mt-3 px-3 pb-3 border-top pt-3">
                    {{ $materials->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    {{-- ===== PANE: FOLDER VIEW ===== --}}
    <div class="cf-pane" id="pane-folders">
        {{-- Removed inline folder creation to maintain DRY principle. Use the global 'New Folder' button instead. --}}

        {{-- Folder Cards Grid --}}
        @if($allFolders->flatten()->count() > 0)
            @foreach($allFolders->flatten()->groupBy('course_id') as $courseId => $courseFolders)
            <div style="padding: 16px 24px 4px;">
                <div style="font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.08em;">
                    <i class="fas fa-graduation-cap" style="color: var(--primary);"></i>
                    {{ $courseFolders->first()->course->course_code ?? 'Course' }} — {{ $courseFolders->first()->course->title ?? '' }}
                </div>
            </div>
            <div class="folder-grid" style="padding-top: 10px; padding-bottom: 10px;">
                @foreach($courseFolders as $folder)
                <div class="folder-card" onclick="window.location.href='{{ route('admin.course-files.index', ['folder_id' => $folder->id]) }}'">
                    <div class="folder-ico"><i class="fas fa-folder"></i></div>
                    <div>
                        <div class="folder-name">{{ $folder->name }}</div>
                        <div class="folder-meta">
                            <i class="fas fa-file"></i>
                            {{ $folder->materials_count }} file{{ $folder->materials_count !== 1 ? 's' : '' }}
                            &nbsp;·&nbsp;
                            <i class="fas fa-user"></i>
                            {{ $folder->creator->name ?? 'Admin' }}
                        </div>
                    </div>
                    <form action="{{ route('admin.course-folders.destroy', $folder->id) }}" method="POST" class="folder-del-form" onclick="event.stopPropagation();" style="position: absolute; top: 12px; right: 12px; z-index: 10;">
                        @csrf @method('DELETE')
                        <button type="button" class="action-btn delete delete-btn" title="Delete Folder" style="opacity: 1 !important; visibility: visible !important;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
            @endforeach
        @else
        <div style="text-align: center; padding: 60px 20px; color: var(--text-secondary);">
            <i class="fas fa-folder-open" style="font-size: 4rem; color: var(--border-light); display:block; margin-bottom:16px;"></i>
            <h5 style="font-weight: 700; color: var(--text-heading); margin-bottom: 8px;">No Folders Yet</h5>
            <p style="font-size: 0.9rem; max-width:380px; margin: 0 auto;">Create your first folder using the form above to start organizing course materials.</p>
        </div>
        @endif
    </div>

</div>
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
                <form action="{{ route('admin.course-files.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Teacher</label>
                            <select name="uploaded_by" id="add_teacher" class="form-select" required placeholder="Select Faculty">
                                <option value="">Select Faculty</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Course</label>
                            <select name="course_id" id="add_course" class="form-select" required placeholder="Select Course">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Folder <small style="color:var(--text-secondary); font-weight:400;">(Optional)</small></label>
                        <select name="folder_id" id="add_folder_id" class="form-input" style="padding: 9px 13px; border-radius: var(--radius-md);">
                            <option value="">📂 Root (No Folder)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Material Title</label>
                        <input type="text" name="title" class="form-input" placeholder="Enter title" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Choose File</label>
                        <div class="upload-zone position-relative" id="upload_zone_container">
                            <div id="upload_default_ui">
                                <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                <p>Drag &amp; drop your file here, or <span class="browse-link">browse</span></p>
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

<!-- CREATE FOLDER MODAL (shortcut button) -->
<div class="modal fade" id="createFolderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
        <div class="modal-content premium" style="border: none; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
            <div class="modal-body p-0">
                <div style="padding: 32px 32px 24px; position: relative;">
                    <button type="button" class="close-btn" data-bs-dismiss="modal" style="position: absolute; top: 16px; right: 16px; background: transparent; border: none; color: var(--text-muted); font-size: 1.2rem; transition: 0.2s;" onmouseover="this.style.color='var(--danger)';" onmouseout="this.style.color='var(--text-muted)';"><i class="fas fa-xmark"></i></button>
                    
                    <div style="display: flex; flex-direction: column; align-items: center; text-align: center; margin-bottom: 24px;">
                        <div style="width: 64px; height: 64px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.75rem; margin-bottom: 16px; box-shadow: 0 4px 14px 0 rgba(0, 0, 0, 0.05);">
                            <i class="fas fa-folder-plus"></i>
                        </div>
                        <h4 style="font-weight: 700; color: var(--text-heading); margin: 0 0 8px;">Create New Folder</h4>
                        <p style="font-size: 0.85rem; color: var(--text-secondary); margin: 0; line-height: 1.5;">Organize your course materials efficiently by grouping them into a single folder.</p>
                    </div>

                    <form action="{{ route('admin.course-folders.store') }}" method="POST">
                        @csrf
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label class="form-label" style="font-weight: 600; font-size: 0.85rem; color: var(--text-heading); margin-bottom: 8px;">Select Course</label>
                            <select name="course_id" id="modal_create_course" class="form-input" required>
                                <option value="" disabled selected>Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_code }} — {{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom: 32px;">
                            <label class="form-label" style="font-weight: 600; font-size: 0.85rem; color: var(--text-heading); margin-bottom: 8px;">Folder Name</label>
                            <input type="text" name="name" class="form-input" placeholder="e.g. Lecture Notes, Week 1..." required style="height: 44px; border-radius: 8px; border: 1px solid var(--border-light); padding: 0 16px; font-size: 0.9rem; width: 100%; transition: border-color 0.2s, box-shadow 0.2s;">
                        </div>
                        <div style="display:flex; justify-content: space-between; gap: 16px;">
                            <button type="button" class="btn" style="flex: 1; padding: 12px; font-weight: 600; font-size: 0.9rem; border-radius: 8px; background: var(--bg-muted); color: var(--text-secondary); border: 1px solid var(--border-light); transition: 0.2s;" data-bs-dismiss="modal" onmouseover="this.style.background='var(--border-light)';" onmouseout="this.style.background='var(--bg-muted)';">Cancel</button>
                            <button type="submit" class="btn btn-primary" style="flex: 2; padding: 12px; font-weight: 600; font-size: 0.9rem; border-radius: 8px; transition: 0.2s; box-shadow: 0 4px 14px 0 rgba(0,0,0,0.1);" onmouseover="this.style.transform='translateY(-1px)';" onmouseout="this.style.transform='translateY(0)';"><i class="fas fa-folder-plus" style="margin-right: 6px;"></i> Create Folder</button>
                        </div>
                    </form>
                </div>
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
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Teacher</label>
                            <select name="uploaded_by" id="edit_teacher_id" class="form-select" required placeholder="Select Faculty">
                                <option value="">Select Faculty</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Course</label>
                            <select name="course_id" id="edit_course_id" class="form-select" required placeholder="Select Course">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Folder <small style="color:var(--text-secondary); font-weight:400;">(Optional)</small></label>
                        <select name="folder_id" id="edit_folder_id" class="form-input" style="padding: 9px 13px; border-radius: var(--radius-md);">
                            <option value="">📂 Root (No Folder)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Update Title</label>
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
                        <button type="button" class="btn btn-light" style="padding:10px 32px; font-weight:600; border: 1px solid #cbd5e1; background-color: #f1f5f9; color: #334155; box-shadow: 0 2px 4px rgba(0,0,0,0.05);" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
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
                <img id="previewImage" src="" style="width: 100%; height: 100%; object-fit: contain; position: relative; z-index: 2; display: none; margin: auto;">
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function switchTab(tab) {
        document.querySelectorAll('.cf-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.cf-pane').forEach(p => p.classList.remove('active'));
        document.getElementById('tab-' + tab).classList.add('active');
        document.getElementById('pane-' + tab).classList.add('active');
    }

    function openPreviewModal(url, title, ext) {
        document.getElementById('previewModalLabel').innerHTML = '<i class="fas fa-eye"></i> ' + title;
        document.getElementById('iframeLoader').style.display = 'block';
        const isImage = ['png', 'jpg', 'jpeg', 'gif', 'svg'].includes(ext ? ext.toLowerCase() : '');
        const iframe = document.getElementById('previewIframe');
        const img = document.getElementById('previewImage');
        if (isImage) {
            iframe.style.display = 'none'; iframe.src = "";
            img.style.display = 'block'; img.src = url;
            img.onload = function() { document.getElementById('iframeLoader').style.display = 'none'; };
        } else {
            img.style.display = 'none'; img.src = "";
            iframe.style.display = 'block'; iframe.src = url;
        }
        bootstrap.Modal.getOrCreateInstance(document.getElementById('previewModal')).show();
    }

    document.getElementById('previewModal').addEventListener('hidden.bs.modal', function (event) {
        document.getElementById('previewIframe').src = "";
        document.getElementById('previewImage').src = "";
        document.getElementById('iframeLoader').style.display = 'none';
    });

    /**
     * Populate folder <select> based on selected course_id.
     */
    function loadAdminFolders(courseId, selectId) {
        const select = document.getElementById(selectId);
        if (!select) return;
        select.innerHTML = '<option value="">📂 Root (No Folder)</option>';
        if (!courseId) return;
        const courseFolders = adminAllFolders[courseId] || [];
        courseFolders.forEach(function(folder) {
            const opt = document.createElement('option');
            opt.value = folder.id;
            opt.textContent = '📁 ' + folder.name;
            select.appendChild(opt);
        });
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
            sortField: { field: "text", direction: "asc" }
        };
        const tsConfigCourse = { ...tsConfig, wrapperClass: 'ts-wrapper form-select ts-course' };

        if(document.getElementById('add_teacher')) {
            let addT = new TomSelect("#add_teacher", tsConfig);
            let si = addT.dropdown.querySelector('input');
            if(si) si.setAttribute('placeholder', 'Search faculty...');
        }
        if(document.getElementById('edit_teacher_id')) {
            window.editTeacherSelect = new TomSelect("#edit_teacher_id", tsConfig);
            let si = window.editTeacherSelect.dropdown.querySelector('input');
            if(si) si.setAttribute('placeholder', 'Search faculty...');
        }
        if(document.getElementById('add_course')) {
            let addC = new TomSelect("#add_course", tsConfigCourse);
            let si = addC.dropdown.querySelector('input');
            if(si) si.setAttribute('placeholder', 'Search course...');
            addC.on('change', function(val) { loadAdminFolders(val, 'add_folder_id'); });
        }
        if(document.getElementById('edit_course_id')) {
            window.editCourseSelect = new TomSelect("#edit_course_id", tsConfigCourse);
            let si = window.editCourseSelect.dropdown.querySelector('input');
            if(si) si.setAttribute('placeholder', 'Search course...');
            window.editCourseSelect.on('change', function(val) { loadAdminFolders(val, 'edit_folder_id'); });
        }
        
        if(document.getElementById('inline_create_course')) {
            let inlineCreateCourse = new TomSelect("#inline_create_course", tsConfigCourse);
            let si = inlineCreateCourse.dropdown.querySelector('input');
            if(si) si.setAttribute('placeholder', 'Search course...');
        }

        if(document.getElementById('modal_create_course')) {
            let modalCreateCourse = new TomSelect("#modal_create_course", tsConfigCourse);
            let si = modalCreateCourse.dropdown.querySelector('input');
            if(si) si.setAttribute('placeholder', 'Search course...');
        }

        // Edit Modal Population
        const editButtons = document.querySelectorAll('.edit-btn');
        const editForm = document.getElementById('editFileForm');

        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('edit_title').value = this.getAttribute('data-title');
                const courseId = this.getAttribute('data-course');
                const folderId = this.getAttribute('data-folderid');

                if(window.editTeacherSelect) window.editTeacherSelect.setValue(this.getAttribute('data-teacherid'));
                if(window.editCourseSelect) window.editCourseSelect.setValue(courseId);

                // Load folders for selected course, then set current folder
                loadAdminFolders(courseId, 'edit_folder_id');
                setTimeout(function() {
                    const fs = document.getElementById('edit_folder_id');
                    if(fs && folderId) fs.value = folderId;
                }, 50);

                let filePath = this.getAttribute('data-filepath');
                let fileName = filePath ? filePath.split('/').pop() : 'No file';
                document.getElementById('edit_file_name').innerText = fileName;

                let ext = this.getAttribute('data-fileext');
                let iconClass = 'fa-file-alt';
                if (ext === 'PDF') iconClass = 'fa-file-pdf';
                else if (ext === 'DOC' || ext === 'DOCX') iconClass = 'fa-file-word';
                else if (ext === 'XLS' || ext === 'XLSX') iconClass = 'fa-file-excel';
                else if (ext === 'PPT' || ext === 'PPTX') iconClass = 'fa-file-powerpoint';
                else if (ext === 'ZIP' || ext === 'RAR') iconClass = 'fa-file-archive';
                document.getElementById('edit_file_icon').className = 'fas ' + iconClass;

                let actionUrl = "{{ route('admin.course-files.update', ':id') }}";
                editForm.action = actionUrl.replace(':id', id);
            });
        });

        // Delete Confirmations
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This file will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => { if (result.isConfirmed) form.submit(); });
            });
        });

        // Admin Folder Delete Confirmations
        document.querySelectorAll('.admin-folder-delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Delete Folder?',
                    html: "Files inside will be moved to <b>root</b>. The folder cannot be recovered.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Yes, delete!'
                }).then((result) => { if (result.isConfirmed) form.submit(); });
            });
        });

        // File Upload Preview
        const fileInput = document.getElementById('upload_file_input');
        const defaultUI = document.getElementById('upload_default_ui');
        const previewUI = document.getElementById('upload_file_preview');
        const previewName = document.getElementById('preview_file_name');
        const previewSize = document.getElementById('preview_file_size');
        const previewIcon = document.getElementById('preview_file_icon');
        const removeBtn = document.getElementById('btn_remove_file');

        if(fileInput) {
            fileInput.addEventListener('change', function() {
                if(this.files && this.files.length > 0) {
                    const file = this.files[0];
                    previewName.textContent = file.name;
                    let size = file.size;
                    previewSize.textContent = size < 1024 ? size + ' B' : size < 1048576 ? (size/1024).toFixed(1) + ' KB' : (size/1048576).toFixed(2) + ' MB';
                    const ext = file.name.split('.').pop().toLowerCase();
                    let iconClass = 'fa-file-alt';
                    if(['pdf'].includes(ext)) iconClass = 'fa-file-pdf';
                    else if(['doc','docx'].includes(ext)) iconClass = 'fa-file-word';
                    else if(['xls','xlsx','csv'].includes(ext)) iconClass = 'fa-file-excel';
                    else if(['ppt','pptx'].includes(ext)) iconClass = 'fa-file-powerpoint';
                    else if(['zip','rar','7z'].includes(ext)) iconClass = 'fa-file-archive';
                    else if(['jpg','jpeg','png','gif'].includes(ext)) iconClass = 'fa-file-image';
                    else if(['mp4','avi','mkv'].includes(ext)) iconClass = 'fa-file-video';
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

        // Restore active tab if redirected back with error
        @if(session('active_tab') === 'folders')
        switchTab('folders');
        @endif
    });
</script>
@endpush
