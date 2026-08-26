@extends('layouts.student')

@section('title', 'Subcategory List — StudentHub OBE')
@section('page-title', 'Subcategory List')
@section('breadcrumb', 'Subcategory List')

@section('content')

@forelse($subcategories as $index => $subcategory)
@php
    // Slight animation delay stagger
    $delay = 0.05 * ($index + 1);
    
    // Alternate icon colors based on index for visual flair
    $iconBg = $index % 2 == 0 ? '#f0fdf4' : '#eff6ff';
    $iconColor = $index % 2 == 0 ? '#059669' : '#2563eb';
    $badgeClass = $index % 2 == 0 ? 'b-green' : 'b-blue';
@endphp
<div class="d-card" style="animation-delay:{{ $delay }}s; margin-bottom: 2rem;">
    <div class="d-card-header" style="flex-wrap: wrap;">
        <div class="d-card-title" style="flex: 1; min-width: 0; word-break: break-word;">
            <div class="d-card-ico" style="background:{{ $iconBg }};color:{{ $iconColor }}; flex-shrink: 0;"><i class="fas fa-layer-group"></i></div>
            <span>{{ $subcategory->name }}</span>
        </div>
        <span class="badge {{ $badgeClass }}" style="white-space: nowrap;">{{ $subcategory->courses->count() }} {{ $subcategory->courses->count() == 1 ? 'Course' : 'Courses' }}</span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl" style="width: 100%; min-width: 600px; text-align: center; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 10%; min-width: 80px;">#</th>
                        <th style="text-align: center; width: 15%; min-width: 120px;">Course Code</th>
                        <th style="text-align: center; width: 25%; min-width: 150px;">Course Name</th>
                        <th style="text-align: center; width: 35%; min-width: 250px;">Description</th>
                        <th style="text-align: center; width: 15%; min-width: 100px;">Credit</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subcategory->courses as $cIndex => $course)
                    <tr>
                        <td style="text-align: center; max-width: 80px;">
                            <span class="row-num">{{ str_pad($cIndex + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td style="text-align: center; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <span class="t-code">{{ $course->course_code }}</span>
                        </td>
                        <td style="text-align: center; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <span class="t-name" title="{{ $course->title }}">{{ $course->title }}</span>
                        </td>
                        <td style="text-align: center; color:var(--tx-s); max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $course->description }}">
                            <span class="t-desc">{{ \Illuminate\Support\Str::limit($course->description ?? 'No description available', 40) }}</span>
                        </td>
                        <td style="text-align: center; max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <span class="badge b-gray">{{ $course->credit ?? 'N/A' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px; color: var(--tx-s);">
                            <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; gap:10px;">
                                <i class="fas fa-folder-open" style="font-size:2rem; color:var(--b-color);"></i>
                                <span>No courses found in this subcategory.</span>
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
            <div class="empty-title">No Subcategories Found</div>
            <div class="empty-sub">You are not enrolled in any active courses with subcategories.</div>
        </div>
    </div>
</div>
@endforelse

<div class="mt-4">
    {{ $subcategories->links('pagination::bootstrap-5') }}
</div>

@endsection
