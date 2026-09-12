@extends('layouts.teacher')

@section('title', 'Upload Materials — TeacherHub OBE')
@section('page_title', 'Upload Materials')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
    .ts-wrapper.custom-ts { display: block !important; width: 100% !important; padding: 0 !important; border: none !important; background: transparent !important; box-shadow: none !important; margin: 0; }
    .ts-wrapper.custom-ts .ts-control { border: 1px solid #cbd5e1 !important; border-radius: 8px !important; background-color: #f8fafc !important; background-image: none !important; color: #334155 !important; font-size: 0.9rem !important; font-weight: 500 !important; padding: 10px 15px !important; min-height: 44px !important; box-shadow: none !important; display: flex !important; flex-wrap: wrap; align-items: center; gap: 4px; transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease; }
    .ts-wrapper.custom-ts.focus .ts-control { border-color: var(--primary) !important; background-color: #ffffff !important; box-shadow: 0 0 0 3px var(--primary-light) !important; outline: 0 !important; }
    .ts-dropdown { border: 1px solid #cbd5e1 !important; border-radius: 8px !important; background-color: #ffffff !important; box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important; z-index: 9999 !important; overflow: hidden; }
    .ts-dropdown .ts-dropdown-content { max-height: 250px !important; overflow-y: auto !important; padding: 5px 0; }
    
    /* Fix for TomSelect dropdown growing large when cleared */
    .ts-wrapper.custom-ts .ts-control { flex-wrap: nowrap !important; overflow: hidden !important; }
    .ts-wrapper.custom-ts .ts-control > input { width: 0 !important; min-width: 0 !important; padding: 0 !important; margin: 0 !important; border: none !important; opacity: 0 !important; }
    
    .ts-dropdown .option[data-value=""] { display: none !important; }
    .ts-dropdown .option { padding: 8px 15px !important; color: #475569 !important; font-size: 0.9rem !important; cursor: pointer; }
    .ts-dropdown .option:hover, .ts-dropdown .active { background-color: #f1f5f9 !important; color: var(--primary) !important; }
    .ts-dropdown .dropdown-input-wrap { padding: 10px !important; border-bottom: 1px solid #e2e8f0 !important; background: #f8fafc; }
    .ts-dropdown .dropdown-input { border: 1px solid #cbd5e1 !important; border-radius: 6px !important; padding: 8px 12px !important; background: #ffffff !important; color: #334155 !important; font-size: 0.9rem !important; }
    .ts-dropdown .dropdown-input:focus { border-color: var(--primary) !important; outline: none; }
    .ts-control::after { content: ""; display: block; width: 8px; height: 8px; border-right: 2px solid #64748b; border-bottom: 2px solid #64748b; transform: rotate(45deg); position: absolute; right: 15px; top: 42%; transition: transform 0.2s ease; }
    .ts-wrapper.dropdown-active .ts-control::after { transform: rotate(-135deg); top: 48%; }
    .ts-wrapper.dropdown-active .ts-control .item, .ts-wrapper.has-items .ts-control .item { display: block !important; opacity: 1 !important; }

    /* Folder Management Styles */
    .folder-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 12px;
        border-radius: 8px;
        background: var(--bg-muted, #f8fafc);
        border: 1px solid var(--bd-light, #e2e8f0);
        margin-bottom: 6px;
        transition: all 0.2s ease;
    }
    .folder-item:hover { background: var(--primary-light, #eff6ff); border-color: var(--primary, #2563eb); }
    .folder-item:last-child { margin-bottom: 0; }
    .folder-item-name { display: flex; align-items: center; gap: 8px; font-size: 0.82rem; font-weight: 600; color: var(--tx-h, #1e293b); }
    .folder-item-name i { color: #f59e0b; font-size: 0.95rem; }
    .folder-item-count { font-size: 0.72rem; color: var(--tx-s, #64748b); font-weight: 500; }
    .folder-del-btn { background: var(--danger-lt, #fef2f2); border: none; border-radius: 6px; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; color: var(--danger, #ef4444); cursor: pointer; transition: all 0.2s ease; flex-shrink: 0; }
    .folder-del-btn:hover { background: var(--danger, #ef4444); color: #fff; }
    .folder-empty { text-align: center; padding: 20px 10px; color: var(--tx-s, #64748b); font-size: 0.82rem; }
    .folder-empty i { font-size: 2rem; color: var(--bd-dark, #cbd5e1); display: block; margin-bottom: 8px; }
    .folder-badge { background: var(--primary-light, #eff6ff); color: var(--primary, #2563eb); border-radius: 5px; padding: 2px 8px; font-size: 0.68rem; font-weight: 700; }
</style>
@endpush

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div class="heading-group">
        <h2 class="mb-1" style="font-size: 1.5rem; font-weight: 700; color: var(--text-heading); letter-spacing: -0.5px;">Course Materials</h2>
        <p class="text-muted m-0" style="font-size: 0.85rem;">Upload and manage files and resources for your assigned courses.</p>
    </div>
</div>

{{-- Pass folders data to JS --}}
<script>
    const allFoldersData = @json($folders);
</script>

<div class="row g-4">

    {{-- LEFT COLUMN: Upload Form + Folder Manager --}}
    <div class="col-xl-5 col-lg-5 col-12">

        {{-- Upload Form --}}
        <div class="d-card mb-4" style="animation-delay:.05s">
            <div class="d-card-header">
                <div class="d-card-title"><div class="d-card-ico"><i class="fas fa-cloud-arrow-up"></i></div>Add New File</div>
            </div>
            <div class="d-card-body">
                <form action="{{ route('teacher.course-materials.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="fg">
                        <label class="flabel">Select Course</label>
                        <select class="finput" style="cursor:pointer;" name="course_id" id="add_course_id" required onchange="loadFolders(this.value, 'add_folder_id')">
                            <option selected disabled value="">— Select Course —</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_code }} — {{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fg">
                        <label class="flabel">Save to Folder <span style="color:var(--tx-s);font-weight:400;">(Optional)</span></label>
                        <select class="finput" style="cursor:pointer;" name="folder_id" id="add_folder_id">
                            <option value="">📂 Root (No Folder)</option>
                        </select>
                    </div>
                    <div class="fg">
                        <label class="flabel">Material Title</label>
                        <input type="text" class="finput" name="title" placeholder="e.g. Lecture 01 — Introduction" required>
                    </div>
                    <div class="fg">
                        <label class="flabel">File Privacy</label>
                        <div class="priv-seg">
                            <input type="radio" name="is_active" value="1" id="pub" checked>
                            <label for="pub"><i class="fas fa-globe" style="font-size:.72rem;"></i> Public</label>
                            <input type="radio" name="is_active" value="0" id="me">
                            <label for="me"><i class="fas fa-lock" style="font-size:.70rem;"></i> Only Me</label>
                        </div>
                    </div>
                    <div class="fg">
                        <label class="flabel">Upload File</label>
                        <div class="upload-z" id="dropZone" onclick="document.getElementById('fileIn').click()">
                            <div class="upload-z-ico"><i class="fas fa-file-arrow-up"></i></div>
                            <div class="upload-z-txt" id="fileText">Click or drag &amp; drop your file here</div>
                            <div class="upload-z-hint">PDF · DOCX · PPTX — Max 20 MB</div>
                            <input type="file" hidden id="fileIn" name="file" required onchange="document.getElementById('fileText').innerText = this.files[0].name">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary" style="width:100%;justify-content:center;padding:11px;">
                        <i class="fas fa-upload"></i> Upload Now
                    </button>
                </form>
            </div>
        </div>

        {{-- Folder Manager --}}
        <div class="d-card" style="animation-delay:.1s">
            <div class="d-card-header">
                <div class="d-card-title"><div class="d-card-ico"><i class="fas fa-folder-plus"></i></div>Manage Folders</div>
                <span class="badge b-blue" style="padding:5px 12px;">
                    {{ $folders->flatten()->count() }} folder{{ $folders->flatten()->count() !== 1 ? 's' : '' }}
                </span>
            </div>
            <div class="d-card-body">
                {{-- Create Folder Form --}}
                <form action="{{ route('teacher.course-folders.store') }}" method="POST" class="mb-3">
                    @csrf
                    <div class="fg">
                        <label class="flabel">Course</label>
                        <select class="finput" name="course_id" id="folder_course_id" required style="cursor:pointer;">
                            <option value="" disabled selected>Select Course</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_code }} — {{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fg" style="margin-bottom: 0;">
                        <label class="flabel">Folder Name</label>
                        <div style="display:flex; gap:8px;">
                            <input type="text" class="finput" name="name" id="folder_name_input" placeholder="e.g. Lecture Notes, Assignments..." required style="flex:1;">
                            <button type="submit" class="btn-primary" style="padding: 10px 16px; white-space:nowrap; flex-shrink:0;" title="Create Folder">
                                <i class="fas fa-folder-plus"></i> Create
                            </button>
                        </div>
                    </div>
                </form>

                <hr style="border-color: var(--bd-light, #e2e8f0); margin: 15px 0;">

                {{-- Folder List --}}
                <div id="folderListContainer" style="max-height: 320px; overflow-y: auto;">
                    @forelse($folders->flatten() as $folder)
                    @php
                        $isActive = isset($activeFolder) && $activeFolder->id == $folder->id;
                    @endphp
                    <div class="folder-item" style="cursor: pointer; {{ $isActive ? 'background: var(--primary-light); border-color: var(--primary);' : '' }}" onclick="window.location.href='{{ route('teacher.course-materials.index', ['folder_id' => $folder->id]) }}'">
                        <div class="folder-item-name">
                            <i class="fas fa-folder"></i>
                            <div>
                                <div>{{ $folder->name }}</div>
                                <div class="folder-item-count">{{ $folder->course->course_code ?? 'N/A' }} · {{ $folder->materials_count }} file{{ $folder->materials_count !== 1 ? 's' : '' }}</div>
                            </div>
                        </div>
                        <form action="{{ route('teacher.course-folders.destroy', $folder->id) }}" method="POST" class="folder-del-form" onclick="event.stopPropagation();">
                            @csrf @method('DELETE')
                            <button type="button" class="folder-del-btn folder-delete-btn" title="Delete Folder">
                                <i class="fas fa-trash-alt" style="font-size:.7rem;"></i>
                            </button>
                        </form>
                    </div>
                    @empty
                    <div class="folder-empty">
                        <i class="fas fa-folder-open"></i>
                        No folders created yet.<br>Create your first folder above.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    {{-- RIGHT COLUMN: File List --}}
    <div class="col-xl-7 col-lg-7 col-12">
        <div class="d-card" style="animation-delay:.12s">
            <div class="d-card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                @if(isset($activeFolder) && $activeFolder)
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <a href="{{ route('teacher.course-materials.index') }}" class="btn btn-sm" style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; font-weight: 600; color: var(--text-heading); background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; padding: 6px 14px; text-decoration: none; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" onmouseover="this.style.background='#e2e8f0';" onmouseout="this.style.background='#f1f5f9';">
                            <i class="fas fa-arrow-left"></i> All Files
                        </a>
                        <div class="d-card-title m-0"><div class="d-card-ico"><i class="fas fa-folder-open" style="color:#f59e0b;"></i></div>{{ $activeFolder->name }}</div>
                    </div>
                @else
                    <div class="d-card-title m-0"><div class="d-card-ico"><i class="fas fa-folder-open"></i></div>Manage Uploaded Materials</div>
                @endif
                <span class="badge b-green" style="padding:5px 12px;">{{ $materials->total() }} file{{ $materials->total() !== 1 ? 's' : '' }}</span>
            </div>
            <div class="d-card-body p0">
                <div class="t-wrap">
                    <table class="t-tbl" style="table-layout: fixed; width: 100%;">
                        <thead><tr>
                            <th class="text-start" style="width: 30%;">File Info</th>
                            <th style="width: 20%; text-align:center;">Course</th>
                            <th style="width: 20%; text-align:center;">Folder</th>
                            <th style="width: 15%; text-align:center;">Privacy</th>
                            <th style="width: 15%; text-align:right;">Action</th>
                        </tr></thead>
                        <tbody>
                            @forelse($materials as $material)
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        @php
                                            $ext = strtolower($material->file_type);
                                            $ico = 'fa-file-alt'; $bg = 'var(--bg-muted)'; $col = 'var(--tx-s)';
                                            if($ext === 'pdf') { $ico = 'fa-file-pdf'; $bg = 'var(--danger-lt)'; $col = 'var(--danger)'; }
                                            elseif(in_array($ext, ['doc','docx'])) { $ico = 'fa-file-word'; $bg = 'var(--info-lt)'; $col = 'var(--info)'; }
                                            elseif(in_array($ext, ['ppt','pptx'])) { $ico = 'fa-file-powerpoint'; $bg = 'var(--warning-lt)'; $col = 'var(--warning)'; }
                                        @endphp
                                        <div class="cat-ico" style="width:34px;height:34px;background:{{ $bg }};color:{{ $col }};">
                                            <i class="fas {{ $ico }}" style="font-size:.85rem;"></i>
                                        </div>
                                        <div>
                                            <div class="t-name" style="font-size:.82rem;">
                                                <a href="{{ route('teacher.course-materials.download', $material->id) }}" target="_blank" style="color:inherit;text-decoration:none;">{{ $material->title }}</a>
                                            </div>
                                            <div class="t-sub">{{ strtoupper($ext) }} · {{ number_format($material->file_size / 1024 / 1024, 2) }} MB</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:center;"><span class="badge b-blue">{{ $material->course->course_code }}</span></td>
                                <td style="text-align:center;">
                                    @if($material->folder)
                                        <span class="folder-badge" title="{{ $material->folder->name }}">
                                            <i class="fas fa-folder" style="color:#f59e0b;"></i>
                                            {{ Str::limit($material->folder->name, 12) }}
                                        </span>
                                    @else
                                        <span style="font-size:0.72rem;color:var(--tx-s);">— Root —</span>
                                    @endif
                                </td>
                                <td style="text-align:center;">
                                    @if($material->is_active)
                                    <span class="badge b-green"><i class="fas fa-globe"></i> Public</span>
                                    @else
                                    <span class="badge b-gray"><i class="fas fa-lock"></i> Only Me</span>
                                    @endif
                                </td>
                                <td style="text-align:right;"><div style="display:flex;gap:5px;justify-content:flex-end;">
                                    @if(in_array($ext, ['pdf', 'png', 'jpg', 'jpeg', 'gif', 'svg']))
                                    <button type="button" onclick="openPreviewModal('{{ route('teacher.course-materials.preview', $material->id) }}', '{{ addslashes($material->title) }}', '{{ $ext }}')" class="btn-ico" style="background-color: var(--primary-light); color: var(--primary);" title="View File"><i class="fas fa-eye"></i></button>
                                    @endif
                                    <button type="button" class="btn-ico bi-ed" data-bs-toggle="modal" data-bs-target="#editModal"
                                        onclick="populateEditModal(
                                            {{ $material->id }},
                                            '{{ addslashes($material->title) }}',
                                            {{ $material->course_id }},
                                            {{ $material->is_active ? 1 : 0 }},
                                            {{ $material->folder_id ?? 'null' }}
                                        )"><i class="fas fa-pen"></i></button>
                                    <form action="{{ route('teacher.course-materials.destroy', $material->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button class="btn-ico bi-del delete-btn" type="submit"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding: 40px 20px; text-align: center;">
                                        <div class="empty-ico" style="font-size: 3rem; color: var(--bd-dark, #cbd5e1); margin-bottom: 15px;"><i class="fas fa-box-open"></i></div>
                                        <h5 style="color: var(--tx-h); font-weight: 600; margin-bottom: 5px;">No Materials Found</h5>
                                        <p style="color: var(--tx-m); font-size: 0.9rem; max-width: 400px; margin: 0 auto;">You have not uploaded any materials for your courses yet.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($materials->hasPages())
                <div style="padding: 12px 16px; border-top: 1px solid var(--bd-light, #e2e8f0);">
                    {{ $materials->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection

@push('modals')
{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header"><h5 class="modal-title"><div class="m-ico"><i class="fas fa-pen"></i></div>Edit Material Info</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="fg">
                        <label class="flabel">Material Title</label>
                        <input type="text" class="finput" name="title" id="edit_title" required>
                    </div>
                    <div class="fg">
                        <label class="flabel">Select Course</label>
                        <select class="finput" style="cursor:pointer;" name="course_id" id="edit_course_id" required onchange="loadFolders(this.value, 'edit_folder_id')">
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_code }} — {{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fg">
                        <label class="flabel">Folder <span style="color:var(--tx-s);font-weight:400;">(Optional)</span></label>
                        <select class="finput" style="cursor:pointer;" name="folder_id" id="edit_folder_id">
                            <option value="">📂 Root (No Folder)</option>
                        </select>
                    </div>
                    <div class="fg" style="margin-bottom:0;">
                        <label class="flabel">Privacy</label>
                        <select class="finput" style="cursor:pointer;" name="is_active" id="edit_privacy" required>
                            <option value="1">Public</option>
                            <option value="0">Only Me</option>
                        </select>
                    </div>
                    <div class="fg" style="margin-top:15px;">
                        <label class="flabel">Replace File (Optional)</label>
                        <div class="upload-z" id="dropZoneEdit" onclick="document.getElementById('fileInEdit').click()">
                            <div class="upload-z-ico"><i class="fas fa-file-arrow-up"></i></div>
                            <div class="upload-z-txt" id="fileTextEdit">Click or drag &amp; drop to replace file</div>
                            <div class="upload-z-hint">PDF · DOCX · PPTX — Max 20 MB</div>
                            <input type="file" hidden id="fileInEdit" name="file" onchange="document.getElementById('fileTextEdit').innerText = this.files[0].name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn-ghost" data-bs-dismiss="modal" style="padding: 9px 20px; font-size: 0.82rem; font-weight: 600; box-shadow: inset 0 0 0 1px #cbd5e1, 0 1px 3px rgba(0,0,0,0.1); background-color: #ffffff; color: #475569; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f1f5f9'" onmouseout="this.style.backgroundColor='#ffffff'">Cancel</button><button type="submit" class="btn-primary"><i class="fas fa-check"></i> Save Changes</button></div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('modals')
{{-- Preview Modal --}}
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">File Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" style="height: 80vh; background-color: #f8f9fa; position: relative;">
                <div id="iframeLoader" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
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
    function openPreviewModal(url, title, ext) {
        document.getElementById('previewModalLabel').innerText = title;
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
    document.getElementById('previewModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('previewIframe').src = "";
        document.getElementById('previewImage').src = "";
        document.getElementById('iframeLoader').style.display = 'none';
    });

    /**
     * Populate a folder <select> based on selected course_id.
     * Uses the globally available allFoldersData object (keyed by course_id).
     */
    function loadFolders(courseId, selectId) {
        const select = document.getElementById(selectId);
        if (!select) return;

        const ts = select.tomselect;
        if (ts) {
            ts.clearOptions();
            ts.addOption({value: '', text: '📂 Root (No Folder)'});
            if (courseId) {
                const courseFolders = allFoldersData[courseId] || [];
                courseFolders.forEach(function(folder) {
                    ts.addOption({value: folder.id, text: '📁 ' + folder.name});
                });
            }
            ts.refreshOptions(false);
            ts.setValue('');
        } else {
            select.innerHTML = '<option value="">📂 Root (No Folder)</option>';
            if (!courseId) return;
            const courseFolders = allFoldersData[courseId] || [];
            courseFolders.forEach(function(folder) {
                const opt = document.createElement('option');
                opt.value = folder.id;
                opt.textContent = '📁 ' + folder.name;
                select.appendChild(opt);
            });
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    let editCourseSelect;
    let editPrivacySelect;

    document.addEventListener('DOMContentLoaded', function() {
        let tsConfig = {
            create: false,
            controlInput: null,
            maxOptions: null,
            allowEmptyOption: true,
            wrapperClass: 'ts-wrapper custom-ts',
            plugins: ['dropdown_input'],
            sortField: { field: "text", direction: "asc" },
            onDelete: function(values, e) { return e ? false : true; }
        };

        let addCourseSelect = new TomSelect('#add_course_id', tsConfig);
        let searchInputAdd = addCourseSelect.dropdown.querySelector('input');
        if(searchInputAdd) searchInputAdd.setAttribute('placeholder', 'Search course...');

        // Listen to TomSelect change event for add form's course
        addCourseSelect.on('change', function(val) {
            loadFolders(val, 'add_folder_id');
        });

        editCourseSelect = new TomSelect('#edit_course_id', tsConfig);
        let searchInputEdit = editCourseSelect.dropdown.querySelector('input');
        if(searchInputEdit) searchInputEdit.setAttribute('placeholder', 'Search course...');

        // Listen to TomSelect change event for edit form's course
        editCourseSelect.on('change', function(val) {
            loadFolders(val, 'edit_folder_id');
        });

        // Initialize TomSelect for folder dropdowns
        if (document.getElementById('add_folder_id')) {
            let addFolderSelect = new TomSelect('#add_folder_id', tsConfig);
            let searchInputFolderAdd = addFolderSelect.dropdown.querySelector('input');
            if (searchInputFolderAdd) searchInputFolderAdd.setAttribute('placeholder', 'Search folder...');
        }
        
        if (document.getElementById('edit_folder_id')) {
            let editFolderSelect = new TomSelect('#edit_folder_id', tsConfig);
            let searchInputFolderEdit = editFolderSelect.dropdown.querySelector('input');
            if (searchInputFolderEdit) searchInputFolderEdit.setAttribute('placeholder', 'Search folder...');
        }

        let tsConfigNoSearch = {
            create: false,
            controlInput: null,
            maxOptions: null,
            wrapperClass: 'ts-wrapper custom-ts',
            onDelete: function(values, e) { return e ? false : true; },
            render: {
                option: function(data, escape) {
                    if (data.value === "1") {
                        return '<div class="px-2 py-1"><span class="badge b-green" style="font-size:0.85rem; padding:6px 12px;"><i class="fas fa-globe"></i> ' + escape(data.text) + '</span></div>';
                    } else {
                        return '<div class="px-2 py-1"><span class="badge b-gray" style="font-size:0.85rem; padding:6px 12px;"><i class="fas fa-lock"></i> ' + escape(data.text) + '</span></div>';
                    }
                },
                item: function(data, escape) {
                    if (data.value === "1") {
                        return '<div style="font-size:0.95rem; font-weight:600; color: #059669; display:flex; align-items:center; gap:6px;"><i class="fas fa-globe"></i> ' + escape(data.text) + '</div>';
                    } else {
                        return '<div style="font-size:0.95rem; font-weight:600; color: #475569; display:flex; align-items:center; gap:6px;"><i class="fas fa-lock"></i> ' + escape(data.text) + '</div>';
                    }
                }
            }
        };
        editPrivacySelect = new TomSelect('#edit_privacy', tsConfigNoSearch);

        // Drag & Drop
        const dz = document.getElementById('dropZone');
        if(dz) {
            ['dragover','dragenter'].forEach(e => dz.addEventListener(e, ev => { ev.preventDefault(); dz.style.borderColor = 'var(--primary)'; dz.style.background = 'var(--primary-light)'; }));
            ['dragleave','drop'].forEach(e => dz.addEventListener(e, ev => { ev.preventDefault(); dz.style.borderColor = ''; dz.style.background = ''; }));
        }
        const dzEdit = document.getElementById('dropZoneEdit');
        if(dzEdit) {
            ['dragover','dragenter'].forEach(e => dzEdit.addEventListener(e, ev => { ev.preventDefault(); dzEdit.style.borderColor = 'var(--primary)'; dzEdit.style.background = 'var(--primary-light)'; }));
            ['dragleave','drop'].forEach(e => dzEdit.addEventListener(e, ev => { ev.preventDefault(); dzEdit.style.borderColor = ''; dzEdit.style.background = ''; }));
        }

        // Delete confirmations
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This material file will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Yes, delete!'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        // Folder delete confirmations
        document.querySelectorAll('.folder-delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Delete Folder?',
                    text: "Files inside will move to root. This cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Yes, delete folder!'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        // Pre-select course and folder if we are viewing a specific folder
        @if(isset($activeFolder) && $activeFolder)
            setTimeout(() => {
                if (typeof addCourseSelect !== 'undefined') {
                    addCourseSelect.setValue("{{ $activeFolder->course_id }}");
                    
                    // Wait for folders to load via AJAX, then select active folder
                    setTimeout(() => {
                        const folderSelect = document.getElementById('add_folder_id');
                        if (folderSelect && folderSelect.tomselect) {
                            folderSelect.tomselect.setValue("{{ $activeFolder->id }}");
                        } else if (folderSelect) {
                            folderSelect.value = "{{ $activeFolder->id }}";
                        }
                    }, 500);
                }
                
                // Pre-select Course for Create Folder form
                const folderCourseSelect = document.getElementById('folder_course_id');
                if (folderCourseSelect) folderCourseSelect.value = "{{ $activeFolder->course_id }}";
            }, 200);
        @endif
    });

    function populateEditModal(id, title, courseId, isActive, folderId) {
        document.getElementById('editForm').action = `/teacher/course-materials/${id}`;
        document.getElementById('edit_title').value = title;

        if(editCourseSelect) {
            editCourseSelect.setValue(courseId);
        } else {
            document.getElementById('edit_course_id').value = courseId;
        }

        // Load folders for the course, then set selected folder
        loadFolders(courseId, 'edit_folder_id');
        setTimeout(function() {
            const folderSelect = document.getElementById('edit_folder_id');
            if(folderSelect && folderSelect.tomselect) {
                folderSelect.tomselect.setValue(folderId || '');
            } else if(folderSelect && folderId) {
                folderSelect.value = folderId;
            }
        }, 50);

        if(editPrivacySelect) {
            editPrivacySelect.setValue(String(isActive));
        } else {
            document.getElementById('edit_privacy').value = isActive;
        }

        document.getElementById('fileInEdit').value = '';
        document.getElementById('fileTextEdit').innerText = 'Click or drag & drop to replace file';
    }
</script>
@endpush
