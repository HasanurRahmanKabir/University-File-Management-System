@extends('layouts.teacher')

@section('title', 'Dashboard — TeacherHub OBE')
@section('page_title', 'Dashboard')

@section('content')
<!-- Hero Banner -->
<div class="hero-banner">
    <div class="hero-inner">
        <div>
            <div class="hero-greeting">Welcome back, <span>{{ Auth::user()->name ?? 'Teacher' }}</span> 👋</div>
            <div class="hero-sub">Here's an overview of your academic workspace for today.</div>
        </div>
        <div class="hero-pill">
            <i class="fas fa-calendar-check" style="font-size:.7rem;"></i>
            Academic Session: Current
        </div>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card sc-green" style="animation-delay:.06s">
        <div class="stat-ico ico-green"><i class="fas fa-book-open"></i></div>
        <div class="stat-body">
            <div class="stat-lbl">Active Courses</div>
            <div class="stat-val" data-count="{{ $activeCoursesCount }}">{{ str_pad($activeCoursesCount, 2, '0', STR_PAD_LEFT) }}</div>
            <div class="stat-sub">Current Academic Semester</div>
        </div>
    </div>
    <div class="stat-card sc-blue" style="animation-delay:.12s">
        <div class="stat-ico ico-blue"><i class="fas fa-user-graduate"></i></div>
        <div class="stat-body">
            <div class="stat-lbl">Total Students</div>
            <div class="stat-val" data-count="{{ $totalStudents }}">{{ $totalStudents }}</div>
            <div class="stat-sub">Across all courses</div>
        </div>
    </div>
    <div class="stat-card sc-purple" style="animation-delay:.18s">
        <div class="stat-ico ico-purple"><i class="fas fa-cloud-upload-alt"></i></div>
        <div class="stat-body">
            <div class="stat-lbl">Total Uploads</div>
            <div class="stat-val" data-count="{{ $totalUploads }}">{{ $totalUploads }}</div>
            <div class="stat-sub">Files & resources</div>
        </div>
    </div>
</div>

<!-- Course Overview Table -->
<div class="d-card" style="animation-delay:.24s">
    <div class="d-card-header">
        <div class="d-card-title">
            <div class="d-card-ico"><i class="fas fa-table-list"></i></div>
            Current Course Overview
        </div>
        <a href="{{ route('teacher.courses.index') }}" class="btn-ghost" style="font-size:.75rem;">
            View All <i class="fas fa-arrow-right" style="font-size:.66rem;"></i>
        </a>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl" style="table-layout: fixed; width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 20%;">Course Code</th>
                        <th style="width: 20%;">Course Title</th>
                        <th style="width: 20%;">Files</th>
                        <th style="width: 20%;">Year</th>
                        <th style="width: 20%; text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentCourses as $course)
                    <tr>
                        <td><span class="t-code">{{ $course->course_code }}</span></td>
                        <td><span class="t-name">{{ $course->title }}</span></td>
                        <td><span class="badge b-blue">{{ $course->materials_count }} files</span></td>
                        <td style="color:var(--tx-s);">{{ date('Y') }}</td>
                        <td style="text-align:right;"><button class="btn-ico bi-view" title="Quick View" data-bs-toggle="modal" data-bs-target="#viewCourseModal{{ $course->id }}"><i class="fas fa-eye"></i></button></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 20px; color: var(--tx-s);">No recent courses found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('modals')
@foreach($recentCourses as $course)
<!-- Quick View Modal for {{ $course->course_code }} -->
<div class="modal fade" id="viewCourseModal{{ $course->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header align-items-center" style="border-bottom: 1px solid var(--sb-border); padding: 15px 20px;">
                <h5 class="modal-title d-flex align-items-center gap-2" style="font-size: 1.1rem; font-weight: 600; flex: 1; min-width: 0;">
                    <div class="m-ico d-flex align-items-center justify-content-center flex-shrink-0" style="background: var(--blue-lt); color: var(--blue); width: 32px; height: 32px; font-size: 0.8rem; border-radius: var(--r-xs);"><i class="fas fa-book-open"></i></div>
                    <span class="text-truncate" style="flex: 1; min-width: 0;">Course Snapshot</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="font-size: 0.8rem;"></button>
            </div>
            <div class="modal-body p-3 p-sm-4">
                <div class="text-center mb-4">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 16px; background: linear-gradient(135deg, var(--blue-lt), #e0e7ff); color: var(--blue); font-size: 1.8rem; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h4 class="mb-2 text-wrap text-break" style="font-size: 1.25rem; font-weight: 700; color: var(--tx-main); line-height: 1.4;">{{ $course->title }}</h4>
                    <span class="badge text-wrap" style="background: var(--bg-body); color: var(--tx-s); border: 1px solid var(--sb-border); font-size: 0.85rem; padding: 6px 12px;"><i class="fas fa-hashtag" style="font-size: 0.7rem; margin-right: 4px;"></i>{{ $course->course_code }}</span>
                </div>
                
                <div style="background: var(--bg-body); border-radius: 12px; padding: 16px; border: 1px solid rgba(0,0,0,0.04);">
                    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-start align-items-sm-center mb-3 pb-3" style="border-bottom: 1px dashed var(--sb-border); gap: 6px;">
                        <span style="color: var(--tx-s); font-size: 0.85rem; font-weight: 500;"><i class="fas fa-building" style="margin-right: 6px; opacity: 0.7;"></i> Department</span>
                        <span class="text-wrap text-break text-start text-sm-end" style="font-weight: 600; color: var(--tx-main); font-size: 0.85rem;">{{ $course->department->name ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-start align-items-sm-center mb-3 pb-3" style="border-bottom: 1px dashed var(--sb-border); gap: 6px;">
                        <span style="color: var(--tx-s); font-size: 0.85rem; font-weight: 500;"><i class="fas fa-users" style="margin-right: 6px; opacity: 0.7;"></i> Total Students</span>
                        <span class="text-wrap text-break text-start text-sm-end" style="font-weight: 600; color: var(--tx-main); font-size: 0.85rem;">{{ $course->enrolled_students ?? 0 }} Students</span>
                    </div>
                    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-start align-items-sm-center" style="gap: 6px;">
                        <span style="color: var(--tx-s); font-size: 0.85rem; font-weight: 500;"><i class="fas fa-file-alt" style="margin-right: 6px; opacity: 0.7;"></i> Total Materials</span>
                        <span class="badge b-blue align-self-start align-self-sm-end" style="font-size: 0.85rem; padding: 5px 10px;">{{ $course->materials_count }} Files</span>
                    </div>
                </div>
        </div>
    </div>
</div>
</div>
@endforeach
@endpush

@push('scripts')
<script>
    // Animated counters
    document.querySelectorAll('.stat-val[data-count]').forEach(el => {
        const target = parseInt(el.dataset.count) || 0, dur = 900;
        if(target === 0) return;
        const obs = new IntersectionObserver(ents => {
            if(!ents[0].isIntersecting) return; 
            obs.disconnect();
            let start = null;
            const step = ts => {
                if(!start) start = ts;
                const pct = Math.min((ts - start) / dur, 1);
                const ease = 1 - Math.pow(1 - pct, 3);
                el.textContent = Math.round(ease * target).toString().padStart(2, '0');
                if(pct < 1) requestAnimationFrame(step);
            };
            requestAnimationFrame(step);
        }, {threshold: .5});
        obs.observe(el);
    });
</script>
@endpush

@endsection