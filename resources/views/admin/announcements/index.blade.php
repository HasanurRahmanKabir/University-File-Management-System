@extends('layouts.admin')
@section('title', 'University Announcements - Admin Dashboard')
@section('page-title', 'University Announcements')
@section('breadcrumb', 'University Announcements')

@push('styles')
<style>
    .premium-table th, .premium-table td {
        padding: 15px 20px;
        vertical-align: middle;
    }
    .badge-custom {
        font-size: 0.75rem;
        padding: 0.4em 0.8em;
        border-radius: 20px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        justify-content: center;
    }
    table { table-layout: fixed; width: 100%; }
    th { color: var(--tx-m); font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid var(--border-color); }
    .col-teacher { width: 16.66%; text-align: left !important; }
    .col-type { width: 16.66%; text-align: center !important; }
    .col-title { width: 16.66%; text-align: center !important; }
    .col-details { width: 16.66%; text-align: center !important; }
    .col-date { width: 16.66%; text-align: center !important; }
    .col-action { width: 16.66%; text-align: right !important; }
    
    .teacher-info img {
        width: 36px;
        height: 36px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid var(--border-color);
    }
</style>
@endpush

@section('content')
<div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div class="heading-group">
        <h2>University Announcements</h2>
        <p>Monitor and manage all class notices and announcements across the university.</p>
    </div>
</div>

    <!-- Stats Row -->
    <!-- Stats Row -->
    <div class="stats-grid grid-3">
        <div class="stat-card {{ !request()->has('status') || request('status') == '' ? 'active-filter' : '' }}" onclick="window.location.href='{{ route('admin.announcements.index') }}'" style="cursor: pointer;" title="View All Announcements">
            <div class="stat-icon-wrap blue"><i class="fas fa-broadcast-tower"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total Announcements</div>
                <div class="stat-number">{{ $totalAnnouncements ?? 0 }}</div>
                <div class="stat-trend neutral"><i class="fas fa-list"></i> All Notices</div>
            </div>
        </div>
        <div class="stat-card {{ request('status') == 'Assignment' ? 'active-filter' : '' }}" onclick="window.location.href='{{ route('admin.announcements.index', ['status' => 'Assignment']) }}'" style="cursor: pointer;" title="Assignments">
            <div class="stat-icon-wrap emerald"><i class="fas fa-tasks"></i></div>
            <div class="stat-info">
                <div class="stat-label">Assignments</div>
                <div class="stat-number">{{ $assignmentCount ?? 0 }}</div>
                <div class="stat-trend up"><i class="fas fa-file-alt"></i> Tasks</div>
            </div>
        </div>
        <div class="stat-card {{ request('status') == 'Exam' ? 'active-filter' : '' }}" onclick="window.location.href='{{ route('admin.announcements.index', ['status' => 'Exam']) }}'" style="cursor: pointer;" title="Exams & Tests">
            <div class="stat-icon-wrap amber"><i class="fas fa-user-edit"></i></div>
            <div class="stat-info">
                <div class="stat-label">Exams & Tests</div>
                <div class="stat-number">{{ $examCtCount ?? 0 }}</div>
                <div class="stat-trend down"><i class="fas fa-clock"></i> Assessments</div>
            </div>
        </div>
    </div>

<div class="data-card">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5 class="card-title"><i class="fas fa-broadcast-tower text-primary"></i> All Announcements</h5>
            <p class="card-subtitle">Showing all recent teacher announcements</p>
        </div>
        <form action="{{ route('admin.announcements.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2" id="searchForm">
            @if(request()->has('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <select name="type_filter" class="form-select m-0" style="width: auto; min-width: 150px; height: 38px;" onchange="this.form.submit()">
                <option value="">All Types</option>
                @foreach($types as $type)
                    <option value="{{ $type }}" {{ request('type_filter') == $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>

            <div class="search-box position-relative m-0" style="height: 38px; flex-grow: 1;">
                <i class="fas fa-search search-icon" style="top: 50%; transform: translateY(-50%);"></i>
                <input type="text" name="search" id="searchInput" placeholder="Search announcements..." value="{{ request('search') }}" style="height: 100%; border-radius: var(--radius-md); padding-right: 30px; width: 100%;">
            </div>
            
            <button type="submit" class="btn btn-primary m-0" style="padding: 0 16px; font-weight: 500; height: 38px; display: flex; align-items: center;">Search</button>

            @if(request('search') || request('type_filter'))
                <a href="{{ route('admin.announcements.index', request()->has('status') ? ['status' => request('status')] : []) }}" class="btn-reset-filter m-0" title="Clear Filters">
                    <i class="fas fa-rotate-left"></i> Reset
                </a>
            @endif
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-wrap table-responsive">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th class="col-teacher">Teacher & Course</th>
                        <th class="col-type">Type</th>
                        <th class="col-title">Title</th>
                        <th class="col-details">Details</th>
                        <th class="col-date">Date/Deadline</th>
                        <th class="col-action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($announcements as $announcement)
                    <tr>
                        <td class="col-teacher">
                            <div class="d-flex align-items-center gap-3 teacher-info">
                                @if(optional($announcement->teacher)->profile_image)
                                    <img src="{{ asset('storage/' . $announcement->teacher->profile_image) }}" alt="Teacher">
                                @else
                                    <div class="avatar-placeholder" style="width:36px;height:36px;border-radius:50%;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:0.9rem;">
                                        {{ strtoupper(substr(optional($announcement->teacher)->name ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">{{ optional($announcement->teacher)->name ?? 'Unknown Teacher' }}</p>
                                    <small class="text-muted" style="font-size: 0.8rem;">
                                        <i class="fas fa-book-open"></i> {{ optional($announcement->course)->course_code ?? 'Course N/A' }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td class="col-type">
                            @if($announcement->type == 'Assignment')
                                <span class="badge bg-warning text-dark badge-custom"><i class="fas fa-tasks"></i> Assignment</span>
                            @elseif($announcement->type == 'Class Test (CT)')
                                <span class="badge bg-danger badge-custom"><i class="fas fa-edit"></i> CT</span>
                            @elseif($announcement->type == 'Exam')
                                <span class="badge bg-primary badge-custom"><i class="fas fa-graduation-cap"></i> Exam</span>
                            @else
                                <span class="badge bg-info text-dark badge-custom"><i class="fas fa-info-circle"></i> Notice</span>
                            @endif
                        </td>
                        <td class="col-title">
                            <span class="text-dark fw-bold" style="font-size: 0.9rem;">{{ $announcement->title }}</span>
                        </td>
                        <td class="col-details">
                            <span class="text-muted" style="font-size: 0.85rem;" title="{{ $announcement->topic_details }}">
                                {{ \Illuminate\Support\Str::limit($announcement->topic_details, 40) }}
                            </span>
                        </td>
                        <td class="col-date">
                            @if($announcement->deadline)
                                <div class="text-warning fw-bold" style="font-size:0.8rem;">
                                    <i class="fas fa-clock"></i> {{ $announcement->deadline->format('d M Y, h:i A') }}
                                </div>
                            @elseif($announcement->exam_date)
                                <div class="text-danger fw-bold" style="font-size:0.8rem;">
                                    <i class="fas fa-calendar-alt"></i> {{ $announcement->exam_date->format('d M Y, h:i A') }}
                                </div>
                            @else
                                <span class="text-muted" style="font-size: 0.85rem;">-</span>
                            @endif
                        </td>
                        <td class="col-action">
                            <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" class="m-0 p-0 delete-form d-flex align-items-center justify-content-end">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="action-btn delete delete-btn" title="Delete Announcement">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding: 60px 20px;">
                                <div class="empty-ico" style="font-size: 4rem; color: var(--border-color); margin-bottom: 20px;">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <h5 class="fw-bold" style="color: var(--tx-h);">No Announcements Found</h5>
                                <p class="text-muted" style="max-width: 400px; margin: 0 auto; text-align: center;">There are no active course announcements in the system.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($announcements->hasPages())
    <div class="card-footer bg-transparent border-top p-3 d-flex justify-content-center">
        {{ $announcements->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // SweetAlert for Delete
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "This announcement will be permanently deleted from the entire system!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#cbd5e1',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@include('partials.sweetalert')
@endpush

