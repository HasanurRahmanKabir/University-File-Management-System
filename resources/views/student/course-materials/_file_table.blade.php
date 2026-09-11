{{-- Partial: student/course-materials/_file_table.blade.php --}}
{{-- Expects: $files (Collection of CourseMaterial) --}}
<table class="cm-file-table">
    <thead>
        <tr>
            <th>Type</th>
            <th>Title</th>
            <th class="text-center">Uploaded</th>
            <th class="text-right" style="text-align:right;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($files as $material)
        @php
            $ext = strtolower($material->file_type ?? 'file');
            $icon = 'fa-file-alt';
            $chipBg = '#f1f5f9'; $chipColor = '#475569';
            if ($ext === 'pdf')                           { $icon = 'fa-file-pdf';        $chipBg = '#fef2f2'; $chipColor = '#dc2626'; }
            elseif (in_array($ext, ['doc','docx']))       { $icon = 'fa-file-word';       $chipBg = '#eff6ff'; $chipColor = '#2563eb'; }
            elseif (in_array($ext, ['xls','xlsx','csv'])) { $icon = 'fa-file-excel';      $chipBg = '#f0fdf4'; $chipColor = '#059669'; }
            elseif (in_array($ext, ['ppt','pptx']))       { $icon = 'fa-file-powerpoint'; $chipBg = '#fffbeb'; $chipColor = '#d97706'; }
            elseif (in_array($ext, ['zip','rar','7z']))   { $icon = 'fa-file-archive';    $chipBg = '#fdf4ff'; $chipColor = '#9333ea'; }
            elseif (in_array($ext, ['jpg','jpeg','png','gif','svg'])) { $icon = 'fa-file-image'; $chipBg = '#f0fdfa'; $chipColor = '#0d9488'; }
            $previewable = in_array($ext, ['pdf','png','jpg','jpeg','gif','svg']);
        @endphp
        <tr>
            <td>
                <span class="cm-file-chip" style="background:{{ $chipBg }}; color:{{ $chipColor }};">
                    <i class="fas {{ $icon }}"></i> {{ strtoupper($ext) }}
                </span>
            </td>
            <td>
                <div class="cm-file-title">{{ $material->title }}</div>
                <div class="cm-file-size">Uploaded {{ $material->created_at->diffForHumans() }}</div>
            </td>
            <td class="text-center" style="white-space:nowrap; font-size:0.78rem; color:var(--text-secondary,#64748b);">
                {{ $material->created_at->format('d M Y') }}
            </td>
            <td>
                <div class="cm-action-group">
                    @if($previewable)
                    <button type="button" class="cm-btn cm-btn-view"
                        onclick="openPreviewModal('{{ route('student.course-materials.preview', $material->id) }}', '{{ addslashes($material->title) }}', '{{ $ext }}')">
                        <i class="fas fa-eye"></i> <span class="d-none d-sm-inline">Preview</span>
                    </button>
                    @endif
                    <a href="{{ route('student.course-materials.download', $material->id) }}"
                       class="cm-btn cm-btn-download">
                        <i class="fas fa-download"></i> <span class="d-none d-sm-inline">Download</span>
                    </a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
