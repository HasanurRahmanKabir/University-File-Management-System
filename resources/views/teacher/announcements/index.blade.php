@extends('layouts.teacher')

@section('title', 'Course Announcements — TeacherHub OBE')
@section('page_title', 'Course Announcements')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
    /* TomSelect — exact same as mycourseinfo.blade.php */
    .ts-wrapper.custom-ts { display: block !important; width: 100% !important; padding: 0 !important; border: none !important; background: transparent !important; box-shadow: none !important; margin: 0; }
    .ts-wrapper.custom-ts .ts-control { border: 1px solid #dee2e6 !important; border-radius: 0.375rem !important; background-color: #fff !important; color: #212529 !important; font-size: 1rem !important; padding: 0.5rem 0.75rem !important; min-height: 48px !important; box-shadow: none !important; display: flex !important; flex-wrap: wrap; align-items: center; gap: 4px; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; }
    .ts-wrapper.custom-ts.focus .ts-control { border-color: #86b7fe !important; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important; outline: 0 !important; }
    .ts-dropdown { border: 1px solid #dee2e6 !important; border-radius: 0.375rem !important; background-color: #fff !important; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important; z-index: 9999 !important; }
    .ts-dropdown .ts-dropdown-content { max-height: 250px !important; overflow-y: auto !important; padding-bottom: 5px; }
    .ts-dropdown .option[data-value=""] { display: none !important; }
    .ts-dropdown .option { padding: 8px 14px !important; color: #212529 !important; font-size: 1rem !important; }
    .ts-dropdown .option:hover, .ts-dropdown .active { background-color: #f8f9fa !important; color: #0d6efd !important; }
    .ts-dropdown .dropdown-input-wrap { padding: 8px !important; border-bottom: 1px solid #e9ecef !important; }
    .ts-dropdown .dropdown-input { border: 1px solid #dee2e6 !important; border-radius: 0.25rem !important; padding: 6px 12px !important; background: #f8f9fa !important; color: #212529 !important; font-size: 1rem !important; }
    .ts-control::after { content: ""; display: block; width: 10px; height: 10px; border-right: 2px solid #888; border-bottom: 2px solid #888; transform: rotate(45deg); position: absolute; right: 15px; top: 40%; transition: transform 0.2s ease; }
    .ts-wrapper.dropdown-active .ts-control::after { transform: rotate(-135deg); top: 45%; }
    .ts-wrapper.dropdown-active .ts-control .item, .ts-wrapper.has-items .ts-control .item { display: block !important; opacity: 1 !important; }
    /* Announcement card */
    .ann-card { border-radius: 12px; border: 1px solid var(--bd-dark, #e2e8f0); background: var(--card-bg, #fff); transition: transform 0.25s ease, box-shadow 0.25s ease; height: 100%; display: flex; flex-direction: column; }
    .ann-card:hover { transform: translateY(-4px); box-shadow: 0 10px 24px rgba(0,0,0,0.09) !important; }
    .ann-badge { font-size: 0.72rem; padding: 0.35em 0.75em; border-radius: 20px; font-weight: 600; }
</style>
@endpush

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div class="heading-group">
        <h2 class="mb-1" style="font-size:1.5rem;font-weight:700;color:var(--text-heading);letter-spacing:-0.5px;">Course Announcements</h2>
        <p class="text-muted m-0" style="font-size:0.85rem;">Manage announcements, assignments, and notices for your courses.</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#announcementModal"
        style="padding:10px 20px;border-radius:8px;font-weight:600;font-size:0.95rem;display:flex;align-items:center;gap:8px;box-shadow:0 4px 12px rgba(59,130,246,0.25);">
        <i class="fas fa-plus-circle"></i> Add Announcement
    </button>
</div>

{{-- Announcements Grid --}}
@if($announcements->isEmpty())
    <div class="d-card" style="animation-delay:.12s">
        <div class="d-card-body">
            <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding:60px 20px;text-align:center;">
                <div class="empty-ico" style="font-size:3.5rem;color:var(--bd-dark,#cbd5e1);margin-bottom:18px;"><i class="fas fa-bullhorn"></i></div>
                <h5 style="color:var(--tx-h);font-weight:700;margin-bottom:6px;">No Announcements Yet</h5>
                <p style="color:var(--tx-m);font-size:0.9rem;max-width:400px;margin:0 auto 20px;">Click "Add Announcement" to create your first notice, assignment, or exam alert for your courses.</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#announcementModal"
                    style="padding:10px 24px;border-radius:8px;font-weight:600;box-shadow:0 4px 12px rgba(59,130,246,0.25);">
                    <i class="fas fa-plus-circle me-2"></i>Add Announcement
                </button>
            </div>
        </div>
    </div>
@else
    <div class="d-card" style="animation-delay:.05s;">
        <div class="d-card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="min-width: 900px; table-layout: fixed; width: 100%;">
                    <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <tr>
                            <th class="text-start" style="width:16.66%; padding: 15px 20px; font-weight: 600; color: #64748b; font-size: 0.85rem; text-transform: uppercase;">Course</th>
                            <th class="text-center" style="width:16.66%; padding: 15px 20px; font-weight: 600; color: #64748b; font-size: 0.85rem; text-transform: uppercase;">Type</th>
                            <th class="text-center" style="width:16.66%; padding: 15px 20px; font-weight: 600; color: #64748b; font-size: 0.85rem; text-transform: uppercase;">Title</th>
                            <th class="text-center" style="width:16.66%; padding: 15px 20px; font-weight: 600; color: #64748b; font-size: 0.85rem; text-transform: uppercase;">Details</th>
                            <th class="text-center" style="width:16.66%; padding: 15px 20px; font-weight: 600; color: #64748b; font-size: 0.85rem; text-transform: uppercase;">Date/Deadline</th>
                            <th class="text-end" style="width:16.66%; padding: 15px 20px; font-weight: 600; color: #64748b; font-size: 0.85rem; text-transform: uppercase;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($announcements as $ann)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td class="text-start" style="padding: 15px 20px;">
                                <span class="badge b-blue" style="font-size:0.78rem;padding:5px 10px;">
                                    {{ optional($ann->course)->course_code ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="text-center" style="padding: 15px 20px;">
                                @if($ann->type == 'Assignment')
                                    <span class="ann-badge" style="background:rgba(245,158,11,0.12);color:#d97706; white-space:nowrap;"><i class="fas fa-tasks me-1"></i>Assignment</span>
                                @elseif($ann->type == 'Class Test (CT)')
                                    <span class="ann-badge" style="background:rgba(239,68,68,0.12);color:#ef4444; white-space:nowrap;"><i class="fas fa-edit me-1"></i>Class Test</span>
                                @elseif($ann->type == 'Exam')
                                    <span class="ann-badge" style="background:rgba(59,130,246,0.12);color:#3b82f6; white-space:nowrap;"><i class="fas fa-graduation-cap me-1"></i>Exam</span>
                                @else
                                    <span class="ann-badge" style="background:rgba(14,165,233,0.12);color:#0ea5e9; white-space:nowrap;"><i class="fas fa-info-circle me-1"></i>Notice</span>
                                @endif
                            </td>
                            <td class="text-center" style="padding: 15px 20px;">
                                <span style="font-weight:600; color:var(--tx-h); font-size:0.95rem; word-break: break-word;">{{ $ann->title }}</span>
                            </td>
                            <td class="text-center" style="padding: 15px 20px;">
                                <span style="color:var(--tx-m); font-size:0.83rem; word-break: break-word; display: block;">
                                    {{ Str::limit($ann->topic_details, 60) }}
                                </span>
                            </td>
                            <td class="text-center" style="padding: 15px 20px;">
                                @if($ann->deadline)
                                <div style="font-size:0.8rem;color:#d97706; margin-bottom: 4px;">
                                    <i class="fas fa-clock"></i> {{ $ann->deadline->format('d M Y, h:i A') }}
                                </div>
                                @endif
                                @if($ann->exam_date)
                                <div style="font-size:0.8rem;color:#ef4444;">
                                    <i class="fas fa-calendar-alt"></i> {{ $ann->exam_date->format('d M Y, h:i A') }}
                                </div>
                                @endif
                            </td>
                            <td class="text-end" style="padding: 15px 20px;">
                                <div class="d-flex align-items-center justify-content-end gap-2">
                                    @if($ann->attachment)
                                    <a href="{{ Storage::url($ann->attachment) }}" target="_blank"
                                       style="width:32px;height:32px;border-radius:6px;border:1px solid #cbd5e1;background:#f8fafc;color:#0ea5e9;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all 0.2s;"
                                       onmouseover="this.style.background='#e0f7ff'" onmouseout="this.style.background='#f8fafc'">
                                        <i class="fas fa-download" style="font-size:0.85rem;"></i>
                                    </a>
                                    @endif
                                    <button class="action-btn edit edit-ann-btn"
                                        style="width:32px;height:32px;border-radius:6px;border:1px solid #cbd5e1;background:#f8fafc;color:#64748b;transition:all 0.2s; padding:0;"
                                        data-bs-toggle="modal" data-bs-target="#announcementModal"
                                        data-id="{{ $ann->id }}"
                                        data-course="{{ $ann->course_id }}"
                                        data-type="{{ $ann->type }}"
                                        data-title="{{ $ann->title }}"
                                        data-topic="{{ $ann->topic_details }}"
                                        data-deadline="{{ $ann->deadline ? $ann->deadline->format('Y-m-d\TH:i') : '' }}"
                                        data-exam="{{ $ann->exam_date ? $ann->exam_date->format('Y-m-d\TH:i') : '' }}"
                                        onmouseover="this.style.background='#f1f5f9';this.style.color='#3b82f6';"
                                        onmouseout="this.style.background='#f8fafc';this.style.color='#64748b';">
                                        <i class="fas fa-pen" style="font-size:0.85rem;"></i>
                                    </button>
                                    <form action="{{ route('teacher.announcements.destroy', $ann) }}" method="POST" class="m-0 p-0 delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="action-btn delete delete-btn"
                                            style="width:32px;height:32px;border-radius:6px;border:1px solid #cbd5e1;background:#f8fafc;color:#ef4444;transition:all 0.2s; padding:0;"
                                            onmouseover="this.style.background='#fef2f2';this.style.borderColor='#fca5a5';"
                                            onmouseout="this.style.background='#f8fafc';this.style.borderColor='#cbd5e1';">
                                            <i class="fas fa-trash" style="font-size:0.85rem;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $announcements->links() }}
    </div>
@endif

@endsection

@push('modals')
{{-- SINGLE MODAL for Add & Edit --}}
<div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border:none;border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" id="modalHeaderBg" style="background:linear-gradient(135deg,var(--primary,#3b82f6) 0%,#2563eb 100%);color:white;border-top-left-radius:16px;border-top-right-radius:16px;padding:1.25rem 1.5rem;border-bottom:none;">
                <h5 class="modal-title" id="announcementModalLabel" style="font-weight:700;font-size:1.1rem;margin:0;display:flex;align-items:center;gap:8px;">
                    <i id="modalHeaderIcon" class="fas fa-plus-circle"></i>
                    <span id="modalTitleText">Add Announcement</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="opacity:0.9;"></button>
            </div>
            <div class="modal-body" style="padding:1.5rem;">
                <form id="announcementForm" action="{{ route('teacher.announcements.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small mb-1">Course <span class="text-danger">*</span></label>
                            <select name="course_id" id="course_id" class="form-select form-select-lg fs-6" required>
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_code }} — {{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small mb-1">Type <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-select form-select-lg fs-6" required>
                                <option value="Notice">Notice</option>
                                <option value="Assignment">Assignment</option>
                                <option value="Class Test (CT)">Class Test (CT)</option>
                                <option value="Exam">Exam</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small mb-1">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control form-control-lg fs-6" placeholder="e.g. CT 1 on Chapter 3" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small mb-1">Topic & Details <span class="text-danger">*</span></label>
                            <textarea name="topic_details" id="topic_details" class="form-control fs-6" rows="4" placeholder="Write full details here..." required style="resize:vertical;"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small mb-1">Assignment Deadline</label>
                            <input type="datetime-local" name="deadline" id="deadline" class="form-control form-control-lg fs-6">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small mb-1">Exam Date & Time</label>
                            <input type="datetime-local" name="exam_date" id="exam_date" class="form-control form-control-lg fs-6">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small mb-1">Attachment <small class="text-muted fw-normal">(Optional, max 5MB)</small></label>
                            <input type="file" name="attachment" id="attachment" class="form-control form-control-lg fs-6">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal"
                            style="padding:10px 24px;border-radius:8px;border:1px solid #cbd5e1;background:#ffffff;color:#475569;box-shadow:0 1px 2px rgba(0,0,0,0.05);transition:all 0.2s;"
                            onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#ffffff'">Cancel</button>
                        <button type="submit" id="submitBtn" class="btn btn-primary fw-bold"
                            style="padding:10px 32px;border-radius:8px;box-shadow:0 4px 10px rgba(59,130,246,0.3);">
                            <span id="submitBtnText">Save Announcement</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Blur datetime-local inputs as soon as a complete date & time is selected
    document.querySelectorAll('input[type="datetime-local"]').forEach(function(input) {
        input.addEventListener('input', function() {
            if (this.value) {
                this.blur();
            }
        });
    });

    // TomSelect — exact same config as mycourseinfo.blade.php
    let tsConfig = {
        create: false,
        controlInput: null,
        maxOptions: null,
        allowEmptyOption: true,
        wrapperClass: 'ts-wrapper custom-ts',
        plugins: ['dropdown_input'],
        sortField: { field: 'text', direction: 'asc' },
        onDelete: function(values, e) { return e ? false : true; }
    };

    window.courseSelect = new TomSelect('#course_id', Object.assign({}, tsConfig, {wrapperClass: 'ts-wrapper custom-ts ts-course'}));
    let searchInput = window.courseSelect.dropdown.querySelector('input');
    if (searchInput) searchInput.setAttribute('placeholder', 'Search course...');

    // Add button — reset modal to ADD mode
    document.querySelector('[data-bs-target="#announcementModal"]:not(.edit-ann-btn)').addEventListener('click', function () {
        document.getElementById('modalTitleText').textContent   = 'Add Announcement';
        document.getElementById('submitBtnText').textContent    = 'Save Announcement';
        document.getElementById('modalHeaderIcon').className    = 'fas fa-plus-circle';
        document.getElementById('modalHeaderBg').style.background = 'linear-gradient(135deg,var(--primary,#3b82f6) 0%,#2563eb 100%)';
        document.getElementById('submitBtn').style.background   = '';
        document.getElementById('submitBtn').style.boxShadow    = '0 4px 10px rgba(59,130,246,0.3)';
        document.getElementById('formMethod').value             = 'POST';
        document.getElementById('announcementForm').action      = '{{ route("teacher.announcements.store") }}';
        document.getElementById('announcementForm').reset();
        window.courseSelect.clear(true);
        window.courseSelect.setValue('');
    });

    // Edit buttons — populate modal with existing data
    document.querySelectorAll('.edit-ann-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id       = this.dataset.id;
            const course   = this.dataset.course;
            const type     = this.dataset.type;
            const title    = this.dataset.title;
            const topic    = this.dataset.topic;
            const deadline = this.dataset.deadline;
            const exam     = this.dataset.exam;

            document.getElementById('modalTitleText').textContent   = 'Edit Announcement';
            document.getElementById('submitBtnText').textContent    = 'Update Announcement';
            document.getElementById('modalHeaderIcon').className    = 'fas fa-pen';
            document.getElementById('modalHeaderBg').style.background = 'linear-gradient(135deg,#1e293b 0%,#334155 100%)';
            document.getElementById('submitBtn').style.background   = '#1e293b';
            document.getElementById('submitBtn').style.boxShadow    = '0 4px 10px rgba(30,41,59,0.3)';
            document.getElementById('formMethod').value             = 'PUT';
            document.getElementById('announcementForm').action      = '/teacher/announcements/' + id;

            document.getElementById('title').value          = title;
            document.getElementById('topic_details').value  = topic;
            document.getElementById('deadline').value        = deadline;
            document.getElementById('exam_date').value       = exam;
            document.getElementById('type').value            = type;

            window.courseSelect.setValue(course);
        });
    });

    // Ensure only one date can be selected at a time
    const deadlineInput = document.getElementById('deadline');
    const examDateInput = document.getElementById('exam_date');

    deadlineInput.addEventListener('change', function() {
        if (this.value) {
            examDateInput.value = '';
        }
    });

    examDateInput.addEventListener('change', function() {
        if (this.value) {
            deadlineInput.value = '';
        }
    });

    // Delete confirm
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "This announcement will be permanently deleted!",
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
