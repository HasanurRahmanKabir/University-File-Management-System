@extends('layouts.student')

@section('title', 'Course File Info — StudentHub OBE')
@section('page-title', 'Course File Info')
@section('breadcrumb', 'Course File Info')

@section('content')

@forelse($courses as $index => $course)
@php
    // Slight animation delay stagger
    $delay = 0.05 * ($index + 1);
    
    // Alternate icon colors based on index for visual flair
    $iconBg = $index % 2 == 0 ? '#eff6ff' : '#f0fdf4';
    $iconColor = $index % 2 == 0 ? '#2563eb' : '#059669';
    $badgeClass = $index % 2 == 0 ? 'b-blue' : 'b-green';
@endphp
<div class="d-card" style="animation-delay:{{ $delay }}s; margin-bottom: 2rem;">
    <div class="d-card-header" style="flex-wrap: wrap;">
        <div class="d-card-title" style="flex: 1; min-width: 0; word-break: break-word;">
            <div class="d-card-ico" style="background:{{ $iconBg }};color:{{ $iconColor }}; flex-shrink: 0;"><i class="fas fa-folder-open"></i></div>
            <span>{{ $course->course_code ?? 'Course' }} <span style="color:var(--tx-s);font-weight:400;">— {{ $course->title ?? 'N/A' }}</span></span>
        </div>
        <span class="badge {{ $badgeClass }}" style="white-space: nowrap;"><i class="fas fa-calendar" style="font-size:.55rem;"></i> {{ Auth::user()->semester ?? 'Current Semester' }}</span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl" style="width: 100%; min-width: 600px; text-align: center; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 25%; min-width: 150px;">File Type</th>
                        <th style="text-align: center; width: 25%; min-width: 150px;">File Description</th>
                        <th style="text-align: center; width: 25%; min-width: 150px;">Size</th>
                        <th style="text-align: center; width: 25%; min-width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($course->materials as $material)
                    @php
                        $size = $material->file_size;
                        $formattedSize = $size >= 1048576 ? round($size / 1048576, 2) . ' MB' : round($size / 1024, 2) . ' KB';
                        
                        $type = strtolower($material->file_type ?? 'file');
                        $typeBadge = 'b-gray';
                        $icon = 'fa-file';
                        if(str_contains($type, 'pdf')) { $typeBadge = 'b-red'; $icon = 'fa-file-pdf'; }
                        elseif(str_contains($type, 'doc') || str_contains($type, 'word')) { $typeBadge = 'b-blue'; $icon = 'fa-file-word'; }
                        elseif(str_contains($type, 'ppt') || str_contains($type, 'powerpoint')) { $typeBadge = 'b-yellow'; $icon = 'fa-file-powerpoint'; }
                        elseif(str_contains($type, 'xls') || str_contains($type, 'excel')) { $typeBadge = 'b-green'; $icon = 'fa-file-excel'; }
                        elseif(str_contains($type, 'zip') || str_contains($type, 'rar')) { $typeBadge = 'b-purple'; $icon = 'fa-file-zipper'; }
                        elseif(str_contains($type, 'image') || str_contains($type, 'png') || str_contains($type, 'jpg')) { $typeBadge = 'b-teal'; $icon = 'fa-file-image'; }
                        elseif(str_contains($type, 'video') || str_contains($type, 'mp4')) { $typeBadge = 'b-red'; $icon = 'fa-file-video'; }
                    @endphp
                    <tr>
                        <td style="text-align: center; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <span class="badge {{ $typeBadge }}"><i class="fas {{ $icon }}"></i> {{ strtoupper($material->file_type ?? 'FILE') }}</span>
                        </td>
                        <td style="text-align: center; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <span class="t-name" title="{{ $material->title }}">{{ $material->title }}</span>
                        </td>
                        <td style="text-align: center; color:var(--tx-s); max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $size ? $formattedSize : 'Unknown' }}
                        </td>
                        <td style="text-align: center;">
                            @if($material->file_path)
                            <a href="{{ route('student.course-materials.download', $material->id) }}" class="act-link"><i class="fas fa-download"></i> Download</a>
                            @else
                            <span class="badge b-gray">No File</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px; color: var(--tx-s);">
                            <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; gap:10px;">
                                <i class="fas fa-folder-open" style="font-size:2rem; color:var(--b-color);"></i>
                                <span>No materials have been uploaded for this course yet.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@empty
<div class="d-card">
    <div class="d-card-body" style="text-align: center; padding: 40px;">
        <div class="empty-state">
            <div class="empty-ico"><i class="fas fa-box-open"></i></div>
            <div class="empty-title">No Courses Enrolled</div>
            <div class="empty-sub">You are not enrolled in any courses, so there are no materials to display. Please contact your department if this is a mistake.</div>
        </div>
    </div>
</div>
@endforelse

<div class="mt-4">
    {{ $courses->links('pagination::bootstrap-5') }}
</div>

@endsection
