@extends('layouts.student')

@section('title', 'Category List — StudentHub OBE')
@section('page-title', 'Category List')
@section('breadcrumb', 'Category List')

@section('content')

@forelse($categories as $index => $category)
@php
    // Slight animation delay stagger
    $delay = 0.05 * ($index + 1);
    
    // Alternate icon colors based on index for visual flair
    $iconBg = $index % 2 == 0 ? '#eff6ff' : '#fffbeb';
    $iconColor = $index % 2 == 0 ? '#2563eb' : '#b45309';
    $badgeClass = $index % 2 == 0 ? 'b-blue' : 'b-yellow';
    $icon = $index % 2 == 0 ? 'fa-code' : 'fa-bolt';
@endphp
<div class="d-card" style="animation-delay:{{ $delay }}s; margin-bottom: 2rem;">
    <div class="d-card-header" style="flex-wrap: wrap;">
        <div class="d-card-title" style="flex: 1; min-width: 0; word-break: break-word;">
            <div class="d-card-ico" style="background:{{ $iconBg }};color:{{ $iconColor }}; flex-shrink: 0;"><i class="fas {{ $icon }}"></i></div>
            <span>{{ $category->name }}</span>
        </div>
        <span class="badge {{ $badgeClass }}" style="white-space: nowrap;">{{ $category->courses->count() }} {{ $category->courses->count() == 1 ? 'Course' : 'Courses' }}</span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl" style="width: 100%; min-width: 600px; text-align: center; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 10%; min-width: 80px;">#</th>
                        <th style="text-align: center; width: 30%; min-width: 150px;">Course Name</th>
                        <th style="text-align: center; width: 30%; min-width: 150px;">Instructor</th>
                        <th style="text-align: center; width: 30%; min-width: 150px;">Course Credit</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($category->courses as $cIndex => $course)
                    <tr>
                        <td style="text-align: center; max-width: 80px;">
                            <span class="row-num">{{ str_pad($cIndex + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td style="text-align: center; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <span class="t-name" title="{{ $course->title }}">{{ $course->title }}</span>
                        </td>
                        <td style="text-align: center; color:var(--tx-s); max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ optional($course->teacher)->name ?? 'TBA' }}
                        </td>
                        <td style="text-align: center; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <span class="badge b-gray">{{ $course->course_credit ?? '3.0 cr' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px; color: var(--tx-s);">
                            <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; gap:10px;">
                                <i class="fas fa-folder-open" style="font-size:2rem; color:var(--b-color);"></i>
                                <span>No courses found in this category.</span>
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
            <div class="empty-title">No Categories Found</div>
            <div class="empty-sub">You are not enrolled in any active category courses.</div>
        </div>
    </div>
</div>
@endforelse

<div class="mt-4">
    {{ $categories->links('pagination::bootstrap-5') }}
</div>

@endsection
