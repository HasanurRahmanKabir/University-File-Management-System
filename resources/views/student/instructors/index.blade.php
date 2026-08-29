@extends('layouts.student')

@section('title', 'My Instructors — StudentHub OBE')
@section('page-title', 'My Instructors')
@section('breadcrumb', 'My Instructors')

@section('content')
<div class="row g-4">
    @forelse($courses as $course)
    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
        <div class="d-card h-100" style="animation-delay: .{{ 5 + ($loop->index * 2) }}s; transition: transform 0.2s ease, box-shadow 0.2s ease;">
            <div class="d-card-body d-flex flex-column" style="padding: 24px;">
                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="flex-shrink-0" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, var(--blue-lt), #e0e7ff); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--blue);">
                        @if(optional($course->teacher)->profile_image)
                            <img src="{{ Storage::url($course->teacher->profile_image) }}" alt="Profile" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; cursor: pointer; transition: opacity 0.2s;" data-bs-toggle="modal" data-bs-target="#imageModal{{ $course->id }}" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                        @else
                            <i class="fas fa-user-tie"></i>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <h5 style="font-size: 1.1rem; font-weight: 700; color: var(--tx-main); margin: 0 0 4px 0; word-break: break-word;">
                            {{ optional($course->teacher)->name ?? 'N/A' }}
                        </h5>
                        <p style="font-size: 0.85rem; color: var(--tx-m); margin: 0; font-weight: 500;">
                            <i class="fas fa-id-badge" style="opacity: 0.7; margin-right: 4px;"></i> 
                            {{ optional($course->teacher)->designation ?? 'N/A' }}
                        </p>
                    </div>
                </div>

                <div class="mb-4" style="background: var(--bg-body); border-radius: 8px; padding: 12px; border: 1px solid var(--sb-border);">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div style="width: 24px; text-align: center; color: var(--tx-s);"><i class="fas fa-envelope"></i></div>
                        <div class="text-truncate" style="font-size: 0.9rem; color: var(--tx-main); font-weight: 500;">
                            @if(optional($course->teacher)->email)
                                <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $course->teacher->email }}" target="_blank" style="color: inherit; text-decoration: none; word-break: break-all; white-space: normal;">{{ $course->teacher->email }}</a>
                            @else
                                <span class="badge b-gray">N/A</span>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 24px; text-align: center; color: var(--tx-s);"><i class="fas fa-phone-alt"></i></div>
                        <div class="text-truncate" style="font-size: 0.9rem; color: var(--tx-main); font-weight: 500;">
                            @if(optional($course->teacher)->contact_number)
                                <a href="tel:{{ $course->teacher->contact_number }}" style="color: inherit; text-decoration: none; word-break: break-all; white-space: normal;">{{ $course->teacher->contact_number }}</a>
                            @else
                                <span class="badge b-gray">N/A</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-auto pt-3" style="border-top: 1px dashed var(--border-light);">
                    <div style="font-size: 0.75rem; color: var(--tx-s); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; font-weight: 600;">Enrolled Course</div>
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <span class="badge b-blue text-truncate" style="font-size: 0.75rem; padding: 4px 8px; max-width: 100%;">{{ $course->course_code }}</span>
                        <span class="text-wrap" style="font-size: 0.9rem; font-weight: 600; color: var(--tx-h); word-break: break-word;">{{ $course->title ?? $course->course_name ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="d-card" style="animation-delay:.12s">
            <div class="d-card-body">
                <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding: 60px 20px; text-align: center;">
                    <div class="empty-ico" style="font-size: 4rem; color: var(--bd-dark, #cbd5e1); margin-bottom: 20px;"><i class="fas fa-user-slash"></i></div>
                    <h4 style="color: var(--tx-h); font-weight: 700; margin-bottom: 8px;">No Instructors Found</h4>
                    <p style="color: var(--tx-m); font-size: 0.95rem; max-width: 450px; margin: 0 auto; line-height: 1.5;">You are currently not enrolled in any courses, or no instructors have been assigned to your courses yet.</p>
                </div>
            </div>
        </div>
    </div>
    @endforelse
</div>

@endsection

@push('modals')
{{-- Generate Modals Outside the Grid Layout to Fix Z-Index and Close Button Issues --}}
@foreach($courses as $course)
    @if(optional($course->teacher)->profile_image)
    <div class="modal fade" id="imageModal{{ $course->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $course->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="background: transparent; border: none; box-shadow: none;">
                <div class="modal-header" style="border: none; padding: 0; justify-content: flex-end; z-index: 1060; position: relative;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: #fff; border-radius: 50%; padding: 12px; margin-bottom: 10px; opacity: 1; box-shadow: 0 4px 12px rgba(0,0,0,0.2); cursor: pointer;"></button>
                </div>
                <div class="modal-body text-center" style="padding: 0; position: relative; z-index: 1055;">
                    <img src="{{ Storage::url($course->teacher->profile_image) }}" alt="Teacher Profile" style="width: auto; height: auto; max-width: 100%; max-height: 85vh; border-radius: 12px; box-shadow: 0 12px 40px rgba(0,0,0,0.4); background: #fff; display: inline-block;">
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
@endpush

@push('styles')
<style>
    .d-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.06);
    }
</style>
@endpush
