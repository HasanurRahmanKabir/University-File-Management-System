@extends('layouts.student')

@section('title', 'Course Materials - StudentHub OBE')
@section('page-title', 'Course Materials')
@section('breadcrumb', 'Course Materials')

@push('styles')
<style>
    .cm-course-block {
        background: var(--bg-card, #ffffff);
        border: 1px solid var(--border-light, #e2e8f0);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        animation: fadeInUp 0.4s ease both;
    }
    @keyframes fadeInUp {
        from { opacity:0; transform:translateY(16px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .cm-course-header {
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; padding: 18px 24px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid var(--border-light, #e2e8f0);
        flex-wrap: wrap;
    }
    .cm-course-header-left { display:flex; align-items:center; gap:14px; min-width:0; }
    .cm-course-ico {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; flex-shrink: 0;
    }
    .cm-course-code { font-size: 1rem; font-weight: 800; color: var(--text-heading, #1e293b); }
    .cm-course-title { font-size: 0.82rem; color: var(--text-secondary, #64748b); font-weight: 500; margin-top:2px; }
    .cm-stats-row {
        display: flex; gap: 8px; flex-wrap: wrap;
        padding: 12px 24px;
        border-bottom: 1px solid var(--border-light, #e2e8f0);
        background: var(--bg-muted, #f8fafc);
    }
    .cm-stat-pill {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 0.72rem; font-weight: 700;
        padding: 4px 10px; border-radius: 20px;
        background: var(--bg-card, #fff);
        border: 1px solid var(--border-light, #e2e8f0);
        color: var(--text-secondary, #64748b);
    }
    .cm-stat-pill i { font-size: 0.65rem; }
    .cm-folder-section { border-bottom: 1px solid var(--border-light, #e2e8f0); }
    .cm-folder-section:last-child { border-bottom: none; }
    .cm-folder-toggle {
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
        width: 100%; padding: 14px 24px;
        background: transparent; border: none; cursor: pointer;
        text-align: left; transition: background 0.2s ease;
        flex-wrap: wrap;
    }
    .cm-folder-toggle:hover { background: var(--bg-muted, #f8fafc); }
    .cm-folder-toggle-left { display: flex; align-items: center; gap: 10px; }
    .cm-folder-ico-wrap {
        width: 36px; height: 36px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        background: #fffbeb; color: #f59e0b; font-size: 1rem; flex-shrink: 0;
    }
    .cm-folder-ico-wrap.root { background: #eff6ff; color: #3b82f6; }
    .cm-folder-label { font-size: 0.88rem; font-weight: 700; color: var(--text-heading, #1e293b); }
    .cm-folder-count { font-size: 0.72rem; color: var(--text-secondary, #64748b); font-weight: 500; margin-top: 1px; }
    .cm-folder-chevron {
        font-size: 0.72rem; color: var(--text-secondary, #64748b);
        transition: transform 0.25s ease; flex-shrink: 0;
    }
    .cm-folder-toggle[aria-expanded="false"] .cm-folder-chevron { transform: rotate(-90deg); }
    .cm-file-table-wrap { overflow-x: auto; }
    .cm-file-table { width: 100%; min-width: 520px; border-collapse: collapse; }
    .cm-file-table thead tr th {
        padding: 9px 20px; font-size: 0.7rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.07em;
        color: var(--text-secondary, #64748b);
        background: var(--bg-muted, #f8fafc);
        border-bottom: 1px solid var(--border-light, #e2e8f0);
        white-space: nowrap;
    }
    .cm-file-table tbody tr { transition: background 0.15s; }
    .cm-file-table tbody tr:hover { background: #f8fafc; }
    .cm-file-table tbody tr:not(:last-child) { border-bottom: 1px solid var(--border-light, #e2e8f0); }
    .cm-file-table td { padding: 12px 20px; vertical-align: middle; font-size: 0.85rem; color: var(--text-body, #334155); }
    .cm-file-chip {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 10px; border-radius: 6px;
        font-size: 0.72rem; font-weight: 700; white-space: nowrap;
    }
    .cm-file-title { font-weight: 600; color: var(--text-heading, #1e293b); line-height: 1.3; word-break: break-word; }
    .cm-file-size  { font-size: 0.72rem; color: var(--text-secondary, #64748b); margin-top: 2px; }
    .cm-action-group { display: flex; gap: 6px; align-items: center; justify-content: flex-end; flex-wrap: nowrap; }
    .cm-btn {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 13px; border-radius: 7px; font-size: 0.75rem; font-weight: 600;
        cursor: pointer; text-decoration: none; border: none; transition: all 0.18s ease;
        white-space: nowrap;
    }
    .cm-btn-view     { background: #eff6ff; color: #2563eb; }
    .cm-btn-view:hover { background: #2563eb; color: #fff; }
    .cm-btn-download { background: #f0fdf4; color: #059669; }
    .cm-btn-download:hover { background: #059669; color: #fff; }
    .cm-folder-empty {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        padding: 30px 20px; gap: 8px;
        color: var(--text-secondary, #64748b); font-size: 0.83rem;
    }
    .cm-folder-empty i { font-size: 2rem; color: #cbd5e1; }
    .cm-no-data {
        text-align: center; padding: 60px 20px;
        background: var(--bg-card, #fff);
        border: 1px solid var(--border-light, #e2e8f0);
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }
    .cm-no-data i { font-size: 4rem; color: #e2e8f0; display:block; margin-bottom: 16px; }
    .cm-no-data h5 { font-weight: 700; color: var(--text-heading, #1e293b); margin-bottom: 6px; }
    .cm-no-data p  { color: var(--text-secondary, #64748b); font-size: 0.9rem; max-width: 380px; margin: 0 auto; }
    @media (max-width: 640px) {
        .cm-course-header { padding: 14px 16px; }
        .cm-stats-row     { padding: 10px 16px; }
        .cm-folder-toggle { padding: 12px 16px; }
        .cm-file-table td, .cm-file-table thead tr th { padding: 10px 12px; }
        .cm-btn { padding: 5px 9px; font-size: 0.7rem; }
    }
</style>
@endpush

@section('content')

@forelse($courses as $index => $course)
@php
    $delay    = 0.05 * ($index + 1);
    $palettes = [
        ['bg'=>'#eff6ff','color'=>'#2563eb'],
        ['bg'=>'#f0fdf4','color'=>'#059669'],
        ['bg'=>'#fdf4ff','color'=>'#9333ea'],
        ['bg'=>'#fff7ed','color'=>'#ea580c'],
        ['bg'=>'#f0fdfa','color'=>'#0d9488'],
    ];
    $p = $palettes[$index % count($palettes)];
    $byFolder  = $course->materials->whereNotNull('folder_id')->groupBy('folder_id');
    $rootFiles = $course->materials->whereNull('folder_id');
    $totalFiles = $course->materials->count();
@endphp

<div class="cm-course-block" style="animation-delay:{{ $delay }}s;">

    {{-- Course Header --}}
    <div class="cm-course-header">
        <div class="cm-course-header-left">
            <div class="cm-course-ico" style="background:{{ $p['bg'] }}; color:{{ $p['color'] }};">
                <i class="fas fa-book-open"></i>
            </div>
            <div>
                <div class="cm-course-code">{{ $course->course_code ?? 'Course' }}</div>
                <div class="cm-course-title">{{ $course->title ?? 'No Title' }}</div>
            </div>
        </div>
        <div style="display:flex; gap:6px; flex-wrap:wrap; align-items:center;">
            <span style="background:{{ $p['bg'] }}; color:{{ $p['color'] }}; border-radius:20px; padding:5px 12px; font-size:0.72rem; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                <i class="fas fa-file-alt" style="font-size:.6rem;"></i> {{ $totalFiles }} File{{ $totalFiles !== 1 ? 's' : '' }}
            </span>
            <span style="background:#f0fdf4; color:#059669; border-radius:20px; padding:5px 12px; font-size:0.72rem; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                <i class="fas fa-folder" style="font-size:.6rem;"></i> {{ $byFolder->count() }} Folder{{ $byFolder->count() !== 1 ? 's' : '' }}
            </span>
        </div>
    </div>

    @if($totalFiles === 0)
    <div class="cm-folder-empty">
        <i class="fas fa-folder-open"></i>
        <span>No materials uploaded for this course yet.</span>
    </div>
    @else

    {{-- Stats Pills --}}
    @php
        $pdfCount   = $course->materials->filter(fn($m) => strtolower($m->file_type) === 'pdf')->count();
        $docCount   = $course->materials->filter(fn($m) => in_array(strtolower($m->file_type), ['doc','docx']))->count();
        $pptCount   = $course->materials->filter(fn($m) => in_array(strtolower($m->file_type), ['ppt','pptx']))->count();
        $otherCount = $totalFiles - $pdfCount - $docCount - $pptCount;
    @endphp
    <div class="cm-stats-row">
        @if($pdfCount > 0)
        <span class="cm-stat-pill" style="color:#dc2626; border-color:#fee2e2; background:#fef2f2;">
            <i class="fas fa-file-pdf"></i> {{ $pdfCount }} PDF
        </span>
        @endif
        @if($docCount > 0)
        <span class="cm-stat-pill" style="color:#2563eb; border-color:#dbeafe; background:#eff6ff;">
            <i class="fas fa-file-word"></i> {{ $docCount }} DOCX
        </span>
        @endif
        @if($pptCount > 0)
        <span class="cm-stat-pill" style="color:#d97706; border-color:#fef3c7; background:#fffbeb;">
            <i class="fas fa-file-powerpoint"></i> {{ $pptCount }} PPTX
        </span>
        @endif
        @if($otherCount > 0)
        <span class="cm-stat-pill">
            <i class="fas fa-file"></i> {{ $otherCount }} Other
        </span>
        @endif
    </div>

    {{-- Named Folder Sections --}}
    @foreach($byFolder as $folderId => $folderFiles)
    @php $folderName = optional($folderFiles->first()->folder)->name ?? 'Folder'; @endphp
    <div class="cm-folder-section">
        <button class="cm-folder-toggle"
                type="button"
                aria-expanded="true"
                aria-controls="folder-{{ $course->id }}-{{ $folderId }}"
                onclick="toggleFolder(this)">
            <div class="cm-folder-toggle-left">
                <div class="cm-folder-ico-wrap"><i class="fas fa-folder"></i></div>
                <div>
                    <div class="cm-folder-label">{{ $folderName }}</div>
                    <div class="cm-folder-count">{{ $folderFiles->count() }} file{{ $folderFiles->count() !== 1 ? 's' : '' }}</div>
                </div>
            </div>
            <i class="fas fa-chevron-down cm-folder-chevron"></i>
        </button>
        <div id="folder-{{ $course->id }}-{{ $folderId }}" class="cm-file-table-wrap">
            @include('student.course-materials._file_table', ['files' => $folderFiles])
        </div>
    </div>
    @endforeach

    {{-- Uncategorised / Root Files --}}
    @if($rootFiles->count() > 0)
    <div class="cm-folder-section">
        <button class="cm-folder-toggle"
                type="button"
                aria-expanded="true"
                aria-controls="root-{{ $course->id }}"
                onclick="toggleFolder(this)">
            <div class="cm-folder-toggle-left">
                <div class="cm-folder-ico-wrap root"><i class="fas fa-inbox"></i></div>
                <div>
                    <div class="cm-folder-label">Uncategorised Files</div>
                    <div class="cm-folder-count">{{ $rootFiles->count() }} file{{ $rootFiles->count() !== 1 ? 's' : '' }} &mdash; not placed in any folder</div>
                </div>
            </div>
            <i class="fas fa-chevron-down cm-folder-chevron"></i>
        </button>
        <div id="root-{{ $course->id }}" class="cm-file-table-wrap">
            @include('student.course-materials._file_table', ['files' => $rootFiles])
        </div>
    </div>
    @endif

    @endif {{-- end totalFiles > 0 --}}
</div>
@empty
<div class="cm-no-data">
    <i class="fas fa-box-open"></i>
    <h5>No Courses Enrolled</h5>
    <p>You are not enrolled in any courses, so there are no materials to display. Please contact your department if this is a mistake.</p>
</div>
@endforelse

@if($courses->hasPages())
<div class="mt-4">
    {{ $courses->links('pagination::bootstrap-5') }}
</div>
@endif

@endsection

@push('modals')
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
    function toggleFolder(btn) {
        const targetId   = btn.getAttribute('aria-controls');
        const target     = document.getElementById(targetId);
        const isExpanded = btn.getAttribute('aria-expanded') === 'true';
        if (isExpanded) {
            target.style.overflow   = 'hidden';
            target.style.maxHeight  = target.scrollHeight + 'px';
            requestAnimationFrame(() => {
                target.style.transition = 'max-height 0.28s ease, opacity 0.28s ease';
                target.style.maxHeight  = '0';
                target.style.opacity    = '0';
            });
            btn.setAttribute('aria-expanded', 'false');
        } else {
            target.style.maxHeight  = '0';
            target.style.opacity    = '0';
            target.style.overflow   = 'hidden';
            target.style.transition = 'max-height 0.28s ease, opacity 0.28s ease';
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    target.style.maxHeight = target.scrollHeight + 'px';
                    target.style.opacity   = '1';
                });
            });
            target.addEventListener('transitionend', function h() {
                target.style.overflow  = '';
                target.style.maxHeight = '';
                target.removeEventListener('transitionend', h);
            });
            btn.setAttribute('aria-expanded', 'true');
        }
    }

    function openPreviewModal(url, title, ext) {
        document.getElementById('previewModalLabel').innerText = title || 'File Preview';
        document.getElementById('iframeLoader').style.display  = 'block';
        const isImage = ['png','jpg','jpeg','gif','webp'].includes(ext ? ext.toLowerCase() : '');
        const iframe  = document.getElementById('previewIframe');
        const img     = document.getElementById('previewImage');
        if (isImage) {
            iframe.style.display = 'none'; iframe.src = '';
            img.style.display    = 'block'; img.src   = url;
            img.onload = () => document.getElementById('iframeLoader').style.display = 'none';
        } else {
            img.style.display = 'none'; img.src = '';
            iframe.style.display = 'block'; iframe.src = url;
        }
        bootstrap.Modal.getOrCreateInstance(document.getElementById('previewModal')).show();
    }

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.js-preview-material');
        if (!btn) return;
        openPreviewModal(btn.dataset.url, btn.dataset.title, btn.dataset.ext);
    });

    document.getElementById('previewModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('previewIframe').src = '';
        document.getElementById('previewImage').src  = '';
        document.getElementById('iframeLoader').style.display = 'none';
    });
</script>
@endpush
