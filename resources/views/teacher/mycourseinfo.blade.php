@extends('layouts.teacher')

@section('title', 'My Course Info — TeacherHub OBE')
@section('page_title', 'My Course Info')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
    /* Premium Switch styles */
    .custom-switch-container { display: flex; align-items: center; gap: 10px; }
    .custom-switch { position: relative; display: inline-block; width: 48px; height: 24px; }
    .custom-switch input { opacity: 0; width: 0; height: 0; }
    .switch-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .4s; border-radius: 24px; }
    .switch-slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
    input:checked + .switch-slider { background-color: var(--primary); }
    input:checked + .switch-slider:before { transform: translateX(24px); }

    /* Ensure TomSelect perfectly matches the standard form-select design */
    .ts-wrapper.custom-ts { display: block !important; width: 100% !important; padding: 0 !important; border: none !important; background: transparent !important; box-shadow: none !important; margin: 0; }
    .ts-wrapper.custom-ts .ts-control { border: 1px solid #dee2e6 !important; border-radius: 0.375rem !important; background-color: #fff !important; color: #212529 !important; font-size: 1rem !important; padding: 0.5rem 0.75rem !important; min-height: 48px !important; box-shadow: none !important; display: flex !important; flex-wrap: wrap; align-items: center; gap: 4px; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; }
    .ts-wrapper.custom-ts.focus .ts-control { border-color: #86b7fe !important; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important; outline: 0 !important; }
    /* TomSelect Placeholders */
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
</style>
@endpush

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div class="heading-group">
        <h2 class="mb-1" style="font-size: 1.5rem; font-weight: 700; color: var(--text-heading); letter-spacing: -0.5px;">Course Management</h2>
        <p class="text-muted m-0" style="font-size: 0.85rem;">Manage your assigned courses and records.</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal" style="padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);">
        <i class="fas fa-plus-circle"></i> Add Course
    </button>
</div>
<!-- Stats -->
<div class="stats-grid mb-4">
    <div class="stat-card sc-green" style="animation-delay:.06s">
        <div class="stat-ico ico-green"><i class="fas fa-circle-play"></i></div>
        <div class="stat-body">
            <div class="stat-lbl">Running Semester</div>
            <div class="stat-val" style="font-size: 1.4rem;">Spring {{ date('Y') }}</div>
            <div class="stat-sub">Current Academic Session</div>
        </div>
    </div>
    <div class="stat-card sc-blue" style="animation-delay:.12s">
        <div class="stat-ico ico-blue"><i class="fas fa-book-open"></i></div>
        <div class="stat-body">
            <div class="stat-lbl">Active Courses</div>
            <div class="stat-val" data-count="{{ $activeCoursesCount }}">{{ str_pad($activeCoursesCount, 2, '0', STR_PAD_LEFT) }}</div>
            <div class="stat-sub">Currently assigned</div>
        </div>
    </div>
    <div class="stat-card sc-purple" style="animation-delay:.18s">
        <div class="stat-ico ico-purple"><i class="fas fa-users"></i></div>
        <div class="stat-body">
            <div class="stat-lbl">Total Students</div>
            <div class="stat-val" data-count="{{ $totalStudents }}">{{ $totalStudents }}</div>
            <div class="stat-sub">Across all courses</div>
        </div>
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
                <thead><tr><th>Code</th><th>Course Title</th><th>Credit</th><th>Students</th><th class="text-center">Status</th><th class="text-center">Action</th></tr></thead>
                <tbody>
                    @forelse($runningCourses as $course)
                    <tr>
                        <td><span class="t-code">{{ $course->course_code }}</span></td>
                        <td><span class="t-name">{{ $course->title }}</span></td>
                        <td><span class="badge b-gray">{{ $course->credit ?? 'N/A' }}</span></td>
                        <td><span style="font-weight:600;color:var(--tx-h);">{{ $course->enrolled_students }}</span> <span style="color:var(--tx-m);font-size:.75rem;">students</span></td>
                        <td class="text-center">
                            @if($course->is_active)
                                <span class="badge b-green"><i class="fas fa-check-circle" style="margin-right:4px;"></i>Active</span>
                            @else
                                <span class="badge b-gray"><i class="fas fa-times-circle" style="margin-right:4px;"></i>Inactive</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($course->created_by == auth()->id())
                                <div class="action-group d-flex justify-content-center gap-2">
                                    <button class="action-btn edit edit-course-btn" style="width: 32px; height: 32px; border-radius: 6px; border: 1px solid #cbd5e1; background: #f8fafc; color: #64748b; transition: all 0.2s;" data-bs-toggle="modal" data-bs-target="#editCourseModal"
                                        data-id="{{ $course->id }}"
                                        data-code="{{ $course->course_code }}"
                                        data-credit="{{ $course->credit }}"
                                        data-title="{{ $course->title }}"
                                        data-subtitle="{{ $course->subtitle }}"
                                        data-status="{{ $course->is_active ? '1' : '0' }}"
                                        data-department="{{ $course->department_id }}"
                                        data-category="{{ $course->category_id }}"
                                        data-subcategory="{{ $course->subcategory_id }}"
                                        data-semester="{{ $course->semester_id }}"
                                        onmouseover="this.style.background='#f1f5f9'; this.style.color='#3b82f6';" onmouseout="this.style.background='#f8fafc'; this.style.color='#64748b';">
                                        <i class="fas fa-pen" style="font-size: 0.85rem;"></i>
                                    </button>
                                    <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST" class="m-0 p-0 delete-form d-flex align-items-center">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="action-btn delete delete-btn" style="width: 32px; height: 32px; border-radius: 6px; border: 1px solid #cbd5e1; background: #f8fafc; color: #ef4444; transition: all 0.2s;" onmouseover="this.style.background='#fef2f2'; this.style.borderColor='#fca5a5';" onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#cbd5e1';"><i class="fas fa-trash" style="font-size: 0.85rem;"></i></button>
                                    </form>
                                </div>
                            @else
                                <span class="badge b-gray" style="opacity: 0.7;">N/A</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding: 40px 20px; text-align: center;">
                                <div class="empty-ico" style="font-size: 3rem; color: var(--bd-dark, #cbd5e1); margin-bottom: 15px;"><i class="fas fa-folder-open"></i></div>
                                <h5 style="color: var(--tx-h); font-weight: 600; margin-bottom: 5px;">No Running Courses</h5>
                                <p style="color: var(--tx-m); font-size: 0.9rem; max-width: 400px; margin: 0 auto;">There are no active courses assigned to you for the current semester.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
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
                <thead><tr><th>Semester</th><th>Course Code</th><th>Course Title</th><th>Year</th><th>Status</th><th class="text-center">Action</th></tr></thead>
                <tbody>
                    @forelse($previousCourses as $course)
                    <tr>
                        <td><span class="badge b-purple">Fall</span></td>
                        <td><span class="t-code">{{ $course->course_code }}</span></td>
                        <td><span class="t-name">{{ $course->title }}</span></td>
                        <td style="color:var(--tx-s);">{{ $course->created_at->format('Y') }}</td>
                        <td><span class="badge b-green"><i class="fas fa-check" style="margin-right:4px;"></i>Completed</span></td>
                        <td class="text-center">
                            <span class="badge b-gray" style="opacity: 0.7;">N/A</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding: 40px 20px; text-align: center;">
                                <div class="empty-ico" style="font-size: 3rem; color: var(--bd-dark, #cbd5e1); margin-bottom: 15px;"><i class="fas fa-box-archive"></i></div>
                                <h5 style="color: var(--tx-h); font-weight: 600; margin-bottom: 5px;">No Previous Semester Courses</h5>
                                <p style="color: var(--tx-m); font-size: 0.9rem; max-width: 400px; margin: 0 auto;">You have no completed or archived courses from previous semesters.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

        </div>
    </div>
</div>
@endsection

@push('modals')
<!-- ADD COURSE MODAL -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--primary) 0%, #2563eb 100%); color: white; border-top-left-radius: 16px; border-top-right-radius: 16px; padding: 1.25rem 1.5rem; border-bottom: none;">
                <h5 class="modal-title" id="addCourseModalLabel" style="font-weight: 700; font-size: 1.1rem; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-plus-circle"></i> Register Course
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.9;"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
    <form action="{{ route('teacher.courses.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Course Code <span class="text-danger">*</span></label>
                <input type="text" name="course_code" class="form-control form-control-lg fs-6" placeholder="e.g. CSE-201" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Course Credit</label>
                <input type="text" name="credit" class="form-control form-control-lg fs-6" placeholder="e.g. 3.0 or 3 Credits">
            </div>
            <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Course Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control form-control-lg fs-6" placeholder="e.g. Object Oriented Programming" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Course Subtitle</label>
                <input type="text" name="subtitle" class="form-control form-control-lg fs-6" placeholder="e.g. Theory + Lab">
            </div>
            <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Semester <span class="text-danger">*</span></label>
                <select name="semester_id" id="add_semester" class="form-select form-select-lg fs-6" required>
                    <option value="">Select Semester</option>
                    @foreach($semesters as $semester)
                        <option value="{{ $semester->id }}">{{ $semester->name }} {{ $semester->year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Status</label>
                <div class="custom-switch-container">
                    <label class="custom-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span class="switch-slider"></span>
                    </label>
                    <span class="switch-label text-muted small fw-bold">Active</span>
                </div>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Department</label>
                <select name="department_id" id="add_department" class="form-select form-select-lg fs-6">
                    <option value="">Choose Department</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Course Type</label>
                <div class="d-flex flex-wrap gap-3 mt-1">
                    <div class="form-check custom-radio">
                        <input class="form-check-input" type="radio" name="course_type" id="add_type_category" value="category" onchange="toggleAddCourseType()">
                        <label class="form-check-label text-muted small fw-bold" for="add_type_category">Category (Major)</label>
                    </div>
                    <div class="form-check custom-radio">
                        <input class="form-check-input" type="radio" name="course_type" id="add_type_subcategory" value="subcategory" onchange="toggleAddCourseType()">
                        <label class="form-check-label text-muted small fw-bold" for="add_type_subcategory">Subcategory (Minor)</label>
                    </div>
                </div>
            </div>
            <div class="col-12" id="add_category_group" style="display: none;">
                <label class="form-label fw-bold text-dark small mb-1">Category</label>
                <select name="category_id" id="add_category" class="form-select form-select-lg fs-6">
                    <option value="">Choose Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12" id="add_subcategory_group" style="display: none;">
                <label class="form-label fw-bold text-dark small mb-1">Subcategory</label>
                <select name="subcategory_id" id="add_subcategory" class="form-select form-select-lg fs-6">
                    <option value="">Choose Subcategory</option>
                    @foreach($subcategories as $subcat)
                        <option value="{{ $subcat->id }}">{{ $subcat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
            <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal" style="padding: 10px 24px; border-radius: 8px; border: 1px solid #cbd5e1; background: #ffffff; color: #475569; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#ffffff'">Cancel</button>
            <button type="submit" class="btn btn-primary fw-bold" style="padding: 10px 32px; border-radius: 8px; box-shadow: 0 4px 10px rgba(59,130,246,0.3);">Add Course</button>
        </div>
    </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT COURSE MODAL -->
<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%); color: white; border-top-left-radius: 16px; border-top-right-radius: 16px; padding: 1.25rem 1.5rem; border-bottom: none;">
                <h5 class="modal-title" id="editCourseModalLabel" style="font-weight: 700; font-size: 1.1rem; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-pen"></i> Edit Course
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.9;"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
    <form id="editCourseForm" action="" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Course Code <span class="text-danger">*</span></label>
                <input type="text" name="course_code" id="edit_code" class="form-control form-control-lg fs-6" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Course Credit</label>
                <input type="text" name="credit" id="edit_credit" class="form-control form-control-lg fs-6">
            </div>
            <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Course Title <span class="text-danger">*</span></label>
                <input type="text" name="title" id="edit_title" class="form-control form-control-lg fs-6" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Course Subtitle</label>
                <input type="text" name="subtitle" id="edit_subtitle" class="form-control form-control-lg fs-6">
            </div>
            <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Semester <span class="text-danger">*</span></label>
                <select name="semester_id" id="edit_semester" class="form-select form-select-lg fs-6" required>
                    <option value="">Select Semester</option>
                    @foreach($semesters as $semester)
                        <option value="{{ $semester->id }}">{{ $semester->name }} {{ $semester->year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Status</label>
                <div class="custom-switch-container">
                    <label class="custom-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="edit_status" value="1">
                        <span class="switch-slider"></span>
                    </label>
                    <span class="switch-label text-muted small fw-bold">Active</span>
                </div>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Department</label>
                <select name="department_id" id="edit_department" class="form-select form-select-lg fs-6">
                    <option value="">Choose Department</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Course Type</label>
                <div class="d-flex flex-wrap gap-3 mt-1">
                    <div class="form-check custom-radio">
                        <input class="form-check-input" type="radio" name="course_type" id="edit_type_category" value="category" onchange="toggleEditCourseType()">
                        <label class="form-check-label text-muted small fw-bold" for="edit_type_category">Category (Major)</label>
                    </div>
                    <div class="form-check custom-radio">
                        <input class="form-check-input" type="radio" name="course_type" id="edit_type_subcategory" value="subcategory" onchange="toggleEditCourseType()">
                        <label class="form-check-label text-muted small fw-bold" for="edit_type_subcategory">Subcategory (Minor)</label>
                    </div>
                </div>
            </div>
            <div class="col-12" id="edit_category_group" style="display: none;">
                <label class="form-label fw-bold text-dark small mb-1">Category</label>
                <select name="category_id" id="edit_category" class="form-select form-select-lg fs-6">
                    <option value="">Choose Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12" id="edit_subcategory_group" style="display: none;">
                <label class="form-label fw-bold text-dark small mb-1">Subcategory</label>
                <select name="subcategory_id" id="edit_subcategory" class="form-select form-select-lg fs-6">
                    <option value="">Choose Subcategory</option>
                    @foreach($subcategories as $subcat)
                        <option value="{{ $subcat->id }}">{{ $subcat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
            <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal" style="padding: 10px 24px; border-radius: 8px; border: 1px solid #cbd5e1; background: #ffffff; color: #475569; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#ffffff'">Cancel</button>
            <button type="submit" class="btn btn-primary fw-bold" style="background: #1e293b; border: none; padding: 10px 32px; border-radius: 8px; box-shadow: 0 4px 10px rgba(30,41,59,0.3);">Update Course</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize TomSelect with dropdown_input plugin
        let tsConfig = {
            create: false,
            controlInput: null,
            maxOptions: null,
            allowEmptyOption: true,
            wrapperClass: 'ts-wrapper custom-ts',
            plugins: ['dropdown_input'],
            sortField: { field: "text", direction: "asc" },
            onDelete: function(values, e) { return e ? false : true; }
        };

        let addDeptSelect = new TomSelect('#add_department', Object.assign({}, tsConfig, {wrapperClass: 'ts-wrapper custom-ts ts-department'}));
        let searchInputAdd = addDeptSelect.dropdown.querySelector('input');
        if(searchInputAdd) searchInputAdd.setAttribute('placeholder', 'Search department...');
        
        let editDeptSelect = new TomSelect('#edit_department', Object.assign({}, tsConfig, {wrapperClass: 'ts-wrapper custom-ts ts-department'}));
        let searchInputEdit = editDeptSelect.dropdown.querySelector('input');
        if(searchInputEdit) searchInputEdit.setAttribute('placeholder', 'Search department...');

        let addSemesterSelect = new TomSelect('#add_semester', Object.assign({}, tsConfig, {wrapperClass: 'ts-wrapper custom-ts ts-semester'}));
        let addSemInput = addSemesterSelect.dropdown.querySelector('input');
        if(addSemInput) addSemInput.setAttribute('placeholder', 'Search semester...');

        let editSemesterSelect = new TomSelect('#edit_semester', Object.assign({}, tsConfig, {wrapperClass: 'ts-wrapper custom-ts ts-semester'}));
        let editSemInput = editSemesterSelect.dropdown.querySelector('input');
        if(editSemInput) editSemInput.setAttribute('placeholder', 'Search semester...');

        let addCategorySelect = new TomSelect('#add_category', Object.assign({}, tsConfig, {wrapperClass: 'ts-wrapper custom-ts ts-category'}));
        let addCatInput = addCategorySelect.dropdown.querySelector('input');
        if(addCatInput) addCatInput.setAttribute('placeholder', 'Search category...');

        let addSubcategorySelect = new TomSelect('#add_subcategory', Object.assign({}, tsConfig, {wrapperClass: 'ts-wrapper custom-ts ts-subcategory'}));
        let addSubcatInput = addSubcategorySelect.dropdown.querySelector('input');
        if(addSubcatInput) addSubcatInput.setAttribute('placeholder', 'Search subcategory...');

        let editCategorySelect = new TomSelect('#edit_category', Object.assign({}, tsConfig, {wrapperClass: 'ts-wrapper custom-ts ts-category'}));
        let editCatInput = editCategorySelect.dropdown.querySelector('input');
        if(editCatInput) editCatInput.setAttribute('placeholder', 'Search category...');

        let editSubcategorySelect = new TomSelect('#edit_subcategory', Object.assign({}, tsConfig, {wrapperClass: 'ts-wrapper custom-ts ts-subcategory'}));
        let editSubcatInput = editSubcategorySelect.dropdown.querySelector('input');
        if(editSubcatInput) editSubcatInput.setAttribute('placeholder', 'Search subcategory...');

        window.toggleAddCourseType = function() {
            let isCategory = document.getElementById('add_type_category').checked;
            let isSubcategory = document.getElementById('add_type_subcategory').checked;
            
            document.getElementById('add_category_group').style.display = isCategory ? 'block' : 'none';
            document.getElementById('add_subcategory_group').style.display = isSubcategory ? 'block' : 'none';
            
            if(!isCategory) { addCategorySelect.clear(true); addCategorySelect.setValue(''); }
            if(!isSubcategory) { addSubcategorySelect.clear(true); addSubcategorySelect.setValue(''); }
        };

        window.toggleEditCourseType = function() {
            let isCategory = document.getElementById('edit_type_category').checked;
            let isSubcategory = document.getElementById('edit_type_subcategory').checked;
            
            document.getElementById('edit_category_group').style.display = isCategory ? 'block' : 'none';
            document.getElementById('edit_subcategory_group').style.display = isSubcategory ? 'block' : 'none';
            
            if(!isCategory) { editCategorySelect.clear(true); editCategorySelect.setValue(''); }
            if(!isSubcategory) { editSubcategorySelect.clear(true); editSubcategorySelect.setValue(''); }
        };

        // Edit Modal Population
        const editButtons = document.querySelectorAll('.edit-course-btn');
        const editForm = document.getElementById('editCourseForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('edit_code').value = this.getAttribute('data-code');
                document.getElementById('edit_credit').value = this.getAttribute('data-credit');
                document.getElementById('edit_title').value = this.getAttribute('data-title');
                document.getElementById('edit_subtitle').value = this.getAttribute('data-subtitle');
                document.getElementById('edit_status').checked = this.getAttribute('data-status') === '1';
                editSemesterSelect.setValue(this.getAttribute('data-semester'));
                
                // Update TomSelect value
                editDeptSelect.setValue(this.getAttribute('data-department'));
                
                const catId = this.getAttribute('data-category');
                const subcatId = this.getAttribute('data-subcategory');
                
                if (catId) {
                    document.getElementById('edit_type_category').checked = true;
                    editCategorySelect.setValue(catId);
                    editSubcategorySelect.clear(true);
                    editSubcategorySelect.setValue('');
                } else if (subcatId) {
                    document.getElementById('edit_type_subcategory').checked = true;
                    editSubcategorySelect.setValue(subcatId);
                    editCategorySelect.clear(true);
                    editCategorySelect.setValue('');
                } else {
                    document.getElementById('edit_type_category').checked = false;
                    document.getElementById('edit_type_subcategory').checked = false;
                    editCategorySelect.clear(true);
                    editCategorySelect.setValue('');
                    editSubcategorySelect.clear(true);
                    editSubcategorySelect.setValue('');
                }
                window.toggleEditCourseType();
                
                let actionUrl = "{{ route('teacher.courses.update', ':id') }}";
                editForm.action = actionUrl.replace(':id', id);
            });
        });

        // Delete Confirmation
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This course will be permanently deleted!",
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
@endpush
