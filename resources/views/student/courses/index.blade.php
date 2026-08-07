@extends('layouts.student')

@section('title', 'Course Info — StudentHub OBE')
@section('page-title', 'Course Info')
@section('breadcrumb', 'Course Info')

@section('content')
<div class="d-card" style="animation-delay:.05s">
    <div class="d-card-header">
        <div class="d-card-title">
            <div class="d-card-ico" style="background:#eff6ff;color:#2563eb;"><i class="fas fa-graduation-cap"></i></div>
            My Course Information
        </div>
        <span class="badge b-blue"><i class="fas fa-calendar" style="font-size:.55rem;"></i> {{ Auth::user()->semester ?? 'Current' }}</span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl" style="width: 100%; min-width: 840px; text-align: center; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 16.66%; min-width: 140px;">Course Code</th>
                        <th style="text-align: center; width: 16.66%; min-width: 140px;">Course Title</th>
                        <th style="text-align: center; width: 16.66%; min-width: 140px;">Instructor</th>
                        <th style="text-align: center; width: 16.66%; min-width: 140px;">Course Credit</th>
                        <th style="text-align: center; width: 16.66%; min-width: 140px;">Year</th>
                        <th style="text-align: center; width: 16.66%; min-width: 140px;">Semester</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                    @php
                        $month = optional($course->created_at)->format('n');
                        $courseSemester = ($month >= 1 && $month <= 6) ? 'Spring' : 'Fall';
                        $courseYear = optional($course->created_at)->format('Y') ?? 'N/A';
                    @endphp
                    <tr>
                        <td style="text-align: center; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><span class="t-code">{{ $course->course_code }}</span></td>
                        <td style="text-align: center; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><span class="t-name">{{ $course->title ?? $course->course_name ?? 'Course' }}</span></td>
                        <td style="text-align: center; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color:var(--tx-s);">{{ optional($course->teacher)->name ?? 'TBA' }}</td>
                        <td style="text-align: center; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><span class="badge b-gray">{{ $course->course_credit ?? '3.0 cr' }}</span></td>
                        <td style="text-align: center; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color:var(--tx-s);">{{ $courseYear }}</td>
                        <td style="text-align: center; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><span class="badge b-blue">{{ $courseSemester }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 0; border-bottom: none;">
                            <div class="empty-state">
                                <div class="empty-ico"><i class="fas fa-folder-open"></i></div>
                                <div class="empty-title">No Course Records Found</div>
                                <div class="empty-sub">You are not enrolled in any courses for the current or previous semesters. Please contact your department if this is a mistake.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $courses->links('pagination::bootstrap-5') }}
</div>
@endsection
