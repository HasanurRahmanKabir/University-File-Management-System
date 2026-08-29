@extends('layouts.student')

@section('title', 'Class Notices')
@section('page-title', 'Class Notices')
@section('breadcrumb', 'Class Notices')

@push('styles')
<style>
    .announcement-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid var(--border-color, #dee2e6);
        border-radius: 12px;
        background: var(--card-bg, #ffffff);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .announcement-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .badge-custom {
        font-size: 0.75rem;
        padding: 0.4em 0.8em;
        border-radius: 20px;
        font-weight: 600;
    }
    .topic-details {
        font-size: 0.95rem;
        color: var(--text-muted, #6c757d);
        flex-grow: 1;
        word-break: break-word;
    }
    .teacher-info img {
        width: 32px;
        height: 32px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid var(--border-color, #dee2e6);
    }
</style>
@endpush

@section('content')
    @if($announcements->isEmpty())
        <div class="d-card" style="animation-delay:.12s">
            <div class="d-card-body">
                <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding:60px 20px;text-align:center;">
                    <div class="empty-ico" style="font-size:4rem;color:var(--bd-dark,#cbd5e1);margin-bottom:20px;">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <h5 style="color:var(--tx-h);font-weight:600;margin-bottom:8px;font-size:1.5rem;">No Announcements Found</h5>
                    <p style="color:var(--tx-m);font-size:1rem;max-width:500px;margin:0 auto;">You're all caught up! There are no notices for your enrolled courses right now.</p>
                </div>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($announcements as $announcement)
            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                <div class="card announcement-card shadow-sm">
                    <div class="card-header bg-transparent border-bottom pt-4 pb-3 px-4 d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-primary mb-1 fw-bold">{{ optional($announcement->course)->course_code ?? 'Course N/A' }}</h6>
                            <small class="text-muted">{{ optional($announcement->course)->title ?? 'N/A' }}</small>
                        </div>
                        <div>
                            @if($announcement->type == 'Assignment')
                                <span class="badge bg-warning text-dark badge-custom"><i class="fas fa-tasks me-1"></i> Assignment</span>
                            @elseif($announcement->type == 'Class Test (CT)')
                                <span class="badge bg-danger badge-custom"><i class="fas fa-edit me-1"></i> CT</span>
                            @elseif($announcement->type == 'Exam')
                                <span class="badge bg-primary badge-custom"><i class="fas fa-graduation-cap me-1"></i> Exam</span>
                            @else
                                <span class="badge bg-info text-dark badge-custom"><i class="fas fa-info-circle me-1"></i> Notice</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="text-dark fw-bold mb-3">{{ $announcement->title }}</h5>
                        <p class="topic-details mb-4 text-muted">{{ $announcement->topic_details }}</p>

                        <div class="mt-auto">
                            @if($announcement->deadline)
                                <div class="p-3 rounded mb-3 bg-warning bg-opacity-10 border border-warning border-opacity-25">
                                    <div class="d-flex align-items-center text-warning">
                                        <i class="fas fa-clock fs-5 me-3"></i>
                                        <div>
                                            <small class="d-block fw-bold text-uppercase" style="font-size:0.7rem;">Deadline</small>
                                            <span class="fw-bold">{{ $announcement->deadline->format('d M Y, h:i A') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @elseif($announcement->exam_date)
                                <div class="p-3 rounded mb-3 bg-danger bg-opacity-10 border border-danger border-opacity-25">
                                    <div class="d-flex align-items-center text-danger">
                                        <i class="fas fa-calendar-alt fs-5 me-3"></i>
                                        <div>
                                            <small class="d-block fw-bold text-uppercase" style="font-size:0.7rem;">Exam Date</small>
                                            <span class="fw-bold">{{ $announcement->exam_date->format('d M Y, h:i A') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-3">
                                <div class="teacher-info d-flex align-items-center">
                                    @php
                                        $profileImg = optional($announcement->teacher)->profile_image
                                            ? Storage::url($announcement->teacher->profile_image)
                                            : asset('images/default-avatar.png');
                                    @endphp
                                    <img src="{{ $profileImg }}" alt="Teacher" class="me-2">
                                    <div>
                                        <small class="d-block text-dark mb-0" style="font-size:0.8rem;">{{ optional($announcement->teacher)->name ?? 'Unknown' }}</small>
                                        <small class="text-muted" style="font-size:0.7rem;">{{ $announcement->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                @if($announcement->attachment)
                                    <a href="{{ Storage::url($announcement->attachment) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3">
                                        <i class="fas fa-download me-1"></i> File
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $announcements->links() }}
        </div>
    @endif
@endsection
