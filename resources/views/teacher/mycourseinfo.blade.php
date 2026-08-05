@extends('layouts.teacher')

@section('title', 'My Course Info — TeacherHub OBE')
@section('page_title', 'My Course Info')

@section('content')
<!-- Page Banner -->
<div class="pg-banner">
    <div class="pg-info">
        <div class="pg-title"><i class="fas fa-book-open" style="color:var(--primary);margin-right:8px;"></i> Course Information</div>
        <div class="pg-sub">Manage and view your assigned courses and class schedules.</div>
    </div>
</div>

<!-- Running Semester -->
<div class="d-card" style="animation-delay:.06s">
    <div class="d-card-header">
        <div class="d-card-title">
            <div class="d-card-ico" style="background:var(--success-lt);color:var(--success);"><i class="fas fa-circle-play"></i></div>
            Running Semester
        </div>
        <span class="badge b-green" style="padding:5px 12px;">Spring {{ date('Y') }}</span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl">
                <thead><tr><th>Code</th><th>Course Title</th><th>Credit</th><th>Students</th><th>Schedule</th></tr></thead>
                <tbody>
                    <tr>
                        <td><span class="t-code">CSE-0400</span></td>
                        <td><span class="t-name">System Design Project</span></td>
                        <td><span class="badge b-gray">3.0 cr</span></td>
                        <td><span style="font-weight:600;color:var(--tx-h);">45</span> <span style="color:var(--tx-m);font-size:.75rem;">students</span></td>
                        <td><span style="font-size:.78rem;color:var(--tx-s);display:flex;align-items:center;gap:5px;"><i class="fas fa-clock" style="color:var(--primary);font-size:.68rem;"></i>Mon · 10:00 AM</span></td>
                    </tr>
                    <tr>
                        <td><span class="t-code">CSE-0302</span></td>
                        <td><span class="t-name">Database Systems Lab</span></td>
                        <td><span class="badge b-gray">1.5 cr</span></td>
                        <td><span style="font-weight:600;color:var(--tx-h);">50</span> <span style="color:var(--tx-m);font-size:.75rem;">students</span></td>
                        <td><span style="font-size:.78rem;color:var(--tx-s);display:flex;align-items:center;gap:5px;"><i class="fas fa-clock" style="color:var(--primary);font-size:.68rem;"></i>Wed · 02:00 PM</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Previous Semester -->
<div class="d-card" style="animation-delay:.12s">
    <div class="d-card-header">
        <div class="d-card-title">
            <div class="d-card-ico" style="background:var(--bg-muted);color:var(--tx-s);"><i class="fas fa-clock-rotate-left"></i></div>
            Previous Semester Records
        </div>
        <span class="badge b-gray" style="padding:5px 12px;">Archived</span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl">
                <thead><tr><th>Semester</th><th>Course Code</th><th>Course Title</th><th>Year</th><th>Status</th></tr></thead>
                <tbody>
                    <tr>
                        <td><span class="badge b-purple">Fall</span></td>
                        <td><span class="t-code">CSE-0201</span></td>
                        <td><span class="t-name">Data Structures</span></td>
                        <td style="color:var(--tx-s);">{{ date('Y') - 1 }}</td>
                        <td><span class="badge b-green"><i class="fas fa-check"></i> Completed</span></td>
                    </tr>
                    <tr>
                        <td><span class="badge b-purple">Fall</span></td>
                        <td><span class="t-code">CSE-0101</span></td>
                        <td><span class="t-name">Intro to Computing</span></td>
                        <td style="color:var(--tx-s);">{{ date('Y') - 1 }}</td>
                        <td><span class="badge b-green"><i class="fas fa-check"></i> Completed</span></td>
                    </tr>
                    <tr>
                        <td><span class="badge b-blue">Spring</span></td>
                        <td><span class="t-code">CSE-0305</span></td>
                        <td><span class="t-name">Software Engineering</span></td>
                        <td style="color:var(--tx-s);">{{ date('Y') - 1 }}</td>
                        <td><span class="badge b-green"><i class="fas fa-check"></i> Completed</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
