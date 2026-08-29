@extends('layouts.student')

@section('title', 'Course Info — StudentHub OBE')
@section('page-title', 'Course Info')
@section('breadcrumb', 'Course Info')

@section('content')
<!-- Running Semester -->
<div class="d-card" style="animation-delay:.06s">
    <div class="d-card-header">
        <div class="d-card-title">
            <div class="d-card-ico" style="background:#eff6ff;color:#2563eb;"><i class="fas fa-graduation-cap"></i></div>
            Running Semester
        </div>
        @if($activeSemester)
            <span class="badge b-blue" style="padding:5px 12px;">{{ $activeSemester->name }} {{ $activeSemester->year }}</span>
        @endif
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl">
                <thead>
                    <tr>
                        <th class="text-start" style="width: 15%; min-width: 90px;">Course Code</th>
                        <th class="text-center" style="width: 20%;">Course Title</th>
                        <th class="text-center" style="width: 20%;">Instructor</th>
                        <th class="text-center" style="width: 15%;">Course Credit</th>
                        <th class="text-center" style="width: 15%;">Year</th>
                        <th class="text-end" style="width: 15%; min-width: 90px;">Semester</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($runningCourses as $course)
                    <tr>
                        <td class="text-start" style="white-space: nowrap;"><span class="t-code">{{ $course->course_code }}</span></td>
                        <td class="text-center"><span class="t-name">{{ $course->title ?? $course->course_name ?? 'Course' }}</span></td>
                        <td class="text-center"><span style="color:var(--tx-s);">{{ optional($course->teacher)->name ?? 'TBA' }}</span></td>
                        <td class="text-center"><span class="badge b-gray">{{ $course->credit ?? 'N/A' }}</span></td>
                        <td class="text-center"><span style="color:var(--tx-s);">{{ optional($course->created_at)->format('Y') ?? 'N/A' }}</span></td>
                        <td class="text-end">
                            <span class="badge b-blue">{{ $activeSemester ? $activeSemester->name : 'Current' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding: 40px 20px; text-align: center;">
                                <div class="empty-ico" style="font-size: 3rem; color: var(--bd-dark, #cbd5e1); margin-bottom: 15px;"><i class="fas fa-folder-open"></i></div>
                                <h5 style="color: var(--tx-h); font-weight: 600; margin-bottom: 5px;">No Running Courses</h5>
                                <p style="color: var(--tx-m); font-size: 0.9rem; max-width: 400px; margin: 0 auto;">You are not enrolled in any courses for the current semester.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@forelse($groupedPreviousCourses as $semesterName => $courses)
<div class="d-card mb-4" style="animation-delay:.{{ 12 + ($loop->index * 2) }}s">
    <div class="d-card-header" style="background: #f8fafc; border-bottom: 1px solid var(--border-light); padding: 12px 20px;">
        <div class="d-card-title" style="font-size: 1.1rem; color: var(--text-heading);">
            <div class="d-card-ico" style="background:#eff6ff;color:#2563eb; width: 32px; height: 32px; border-radius: 6px;"><i class="fas fa-calendar-check" style="font-size: 0.9rem;"></i></div>
            {{ $semesterName }}
        </div>
        <span class="badge b-gray" style="padding:5px 12px; font-weight: 600;">{{ $courses->count() }} {{ Str::plural('Course', $courses->count()) }}</span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl">
                <thead>
                    <tr>
                        <th class="text-start" style="width: 20%; min-width: 90px;">Course Code</th>
                        <th class="text-center" style="width: 25%;">Course Title</th>
                        <th class="text-center" style="width: 25%;">Instructor</th>
                        <th class="text-center" style="width: 15%;">Course Credit</th>
                        <th class="text-end" style="width: 15%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                    <tr>
                        <td class="text-start" style="white-space: nowrap;"><span class="t-code">{{ $course->course_code }}</span></td>
                        <td class="text-center"><span class="t-name">{{ $course->title ?? $course->course_name ?? 'Course' }}</span></td>
                        <td class="text-center"><span style="color:var(--tx-s);">{{ optional($course->teacher)->name ?? 'TBA' }}</span></td>
                        <td class="text-center"><span class="badge b-gray">{{ $course->credit ?? 'N/A' }}</span></td>
                        <td class="text-end">
                            <span class="badge b-green"><i class="fas fa-check" style="margin-right:4px;"></i>Completed</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@empty
<div class="d-card" style="animation-delay:.12s">
    <div class="d-card-body">
        <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding: 40px 20px; text-align: center;">
            <div class="empty-ico" style="font-size: 3rem; color: var(--bd-dark, #cbd5e1); margin-bottom: 15px;"><i class="fas fa-box-archive"></i></div>
            <h5 style="color: var(--tx-h); font-weight: 600; margin-bottom: 5px;">No Previous Semester Courses</h5>
            <p style="color: var(--tx-m); font-size: 0.9rem; max-width: 400px; margin: 0 auto;">You have no completed or archived courses from previous semesters.</p>
        </div>
    </div>
</div>
@endforelse

@endsection
