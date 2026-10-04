@extends('layouts.student')

@section('title', 'Category List — Student FMS')
@section('page-title', 'Category List')
@section('breadcrumb', 'Category List')

@push('styles')
<style>
    /* Phone only: full cell text + same column rhythm, swipe instead of "..." */
    @media (max-width: 992px) {
        .cat-course-tbl {
            width: max-content !important;
            min-width: 640px !important;
            table-layout: auto;
        }
        .cat-course-tbl th,
        .cat-course-tbl td {
            max-width: none !important;
            overflow: visible !important;
            text-overflow: clip !important;
            white-space: nowrap !important;
            width: auto !important;
        }
        .cat-course-tbl .t-name,
        .cat-course-tbl .t-code,
        .cat-course-tbl .badge {
            white-space: nowrap !important;
            overflow: visible !important;
            text-overflow: clip !important;
            max-width: none !important;
        }
        .t-wrap { max-width: 100%; }
    }
</style>
@endpush

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
        @if($category->courses->isEmpty())
            <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding: 40px 20px; text-align: center;">
                <div class="empty-ico" style="font-size: 3rem; color: var(--bd-dark, #cbd5e1); margin-bottom: 15px;"><i class="fas fa-folder-open"></i></div>
                <h5 style="color: var(--tx-h); font-weight: 600; margin-bottom: 5px;">No Courses Found</h5>
                <p style="color: var(--tx-m); font-size: 0.9rem; max-width: 400px; margin: 0 auto; white-space: normal;">No courses found in this category.</p>
            </div>
        @else
            <div class="t-wrap">
                <table class="t-tbl cat-course-tbl" style="width: 100%; min-width: 600px; text-align: center; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 10%; min-width: 80px;">#</th>
                            <th style="text-align: center; width: 15%; min-width: 120px;">Course Code</th>
                            <th style="text-align: center; width: 25%; min-width: 150px;">Course Name</th>
                            <th style="text-align: center; width: 25%; min-width: 150px;">Instructor</th>
                            <th style="text-align: center; width: 25%; min-width: 150px;">Course Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category->courses as $cIndex => $course)
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
                            <td style="text-align: center; color:var(--tx-s); max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ optional($course->teacher)->name ?? 'TBA' }}
                            </td>
                            <td style="text-align: center; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <span class="badge b-gray">{{ $course->credit ?? 'N/A' }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@empty
<div class="d-card">
    <div class="d-card-body" style="text-align: center; padding: 40px;">
        <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding: 40px 20px; text-align: center;">
            <div class="empty-ico" style="font-size: 3rem; color: var(--bd-dark, #cbd5e1); margin-bottom: 15px;"><i class="fas fa-box-open"></i></div>
            <h5 style="color: var(--tx-h); font-weight: 600; margin-bottom: 5px;">No Categories Found</h5>
            <p style="color: var(--tx-m); font-size: 0.9rem; max-width: 400px; margin: 0 auto; white-space: normal;">You are not enrolled in any active category courses.</p>
        </div>
    </div>
</div>
@endforelse

<div class="mt-4">
    {{ $categories->links('pagination::bootstrap-5') }}
</div>

@endsection


