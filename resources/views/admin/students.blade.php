@extends('layouts.admin')
@section('title', 'Students - Admin Dashboard')
@section('page-title', 'Student Management')
@section('breadcrumb', 'Student Management')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
    /* Ensure TomSelect perfectly matches the standard form-select design */
    .ts-wrapper.form-select {
        padding: 0 !important;
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
    }
    .ts-control {
        border: 1.5px solid var(--border) !important;
        border-radius: var(--radius-md) !important;
        background: var(--bg-input) !important;
        color: var(--text-body) !important;
        font-size: 0.85rem !important;
        padding: 9px 13px !important;
        min-height: 42px !important;
        box-shadow: var(--shadow-sm) !important;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 4px;
        transition: all var(--duration-base) var(--ease);
    }
    .ts-wrapper.focus .ts-control {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px var(--primary-glow) !important;
        background: white !important;
        outline: none !important;
    }
    /* Fix Placeholder */
    .ts-control .item[data-value=""] {
        color: var(--text-muted) !important;
    }
    .ts-dropdown {
        border: 1px solid var(--border) !important;
        border-radius: var(--radius-md) !important;
        background-color: white !important;
        box-shadow: var(--shadow-md) !important;
        z-index: 9999 !important;
    }
    .ts-dropdown .ts-dropdown-content {
        max-height: 250px !important;
        overflow-y: auto !important;
        padding-bottom: 5px;
    }
    .ts-dropdown .option[data-value=""] {
        display: none !important;
    }
    .ts-dropdown .option {
        padding: 8px 14px !important;
        color: var(--text-body) !important;
        font-size: 0.85rem !important;
    }
    .ts-dropdown .option:hover, .ts-dropdown .active {
        background-color: var(--bg-muted) !important;
        color: var(--primary) !important;
    }
    .ts-dropdown .dropdown-input-wrap {
        padding: 8px !important;
        border-bottom: 1px solid var(--border-light) !important;
    }
    .ts-dropdown .dropdown-input {
        border: 1px solid var(--border) !important;
        border-radius: var(--radius-sm) !important;
        padding: 6px 12px !important;
        background: var(--bg-muted) !important;
        color: var(--text-body) !important;
        font-size: 0.85rem !important;
    }
    .ts-control::after {
        content: "";
        display: block;
        width: 10px;
        height: 10px;
        border-right: 2px solid #888;
        border-bottom: 2px solid #888;
        transform: rotate(45deg);
        position: absolute;
        right: 15px;
        top: 40%;
        transition: transform 0.2s ease;
    }
    .ts-wrapper.dropdown-active .ts-control::after {
        transform: rotate(-135deg);
        top: 45%;
    }
    .ts-wrapper.dropdown-active .ts-control .item, 
    .ts-wrapper.has-items .ts-control .item {
        display: block !important;
        opacity: 1 !important;
    }
    .ts-dropdown .ts-dropdown-content {
        max-height: 250px;
        overflow-y: auto;
    }
</style>
@endpush

@section('content')
    <div class="page-header">
        <div class="heading-group">
            <h2>Student Enrollment Records</h2>
            <p>Manage student profiles, course enrollments, and academic data.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
            <i class="fas fa-user-plus"></i> Add Student
        </button>
    </div>

    <!-- Stats Row -->
    <div class="stats-grid grid-3">
        <div class="stat-card">
            <div class="stat-icon-wrap blue"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total Students</div>
                <div class="stat-number">{{ $totalStudents }}</div>
                <div class="stat-trend up"><i class="fas fa-arrow-up"></i> 12% growth</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrap emerald"><i class="fas fa-user-check"></i></div>
            <div class="stat-info">
                <div class="stat-label">Active Enrolled</div>
                <div class="stat-number">{{ $activeStudents }}</div>
                <div class="stat-trend neutral"><i class="fas fa-check"></i> 95.6% active</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrap amber"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <div class="stat-label">Pending</div>
                <div class="stat-number">{{ $inactiveStudents }}</div>
                <div class="stat-trend down"><i class="fas fa-arrow-down"></i> Needs review</div>
            </div>
        </div>
    </div>

    <!-- Student Table -->
    <div class="data-card">
        <div class="card-header">
            <div>
                <h5 class="card-title"><i class="fas fa-user-graduate"></i> Enrolled Students</h5>
                <p class="card-subtitle">All registered students with course assignments</p>
            </div>
            <form action="{{ route('admin.student-info.index') }}" method="GET" class="d-flex align-items-center gap-2" id="searchForm">
                <div class="search-box position-relative">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="search" id="searchInput" placeholder="Search any field..." value="{{ request('search') }}" style="padding-right: 30px;">
                    @if(request('search'))
                        <button type="button" class="btn-clear-search" onclick="window.location.href='{{ route('admin.student-info.index') }}'" title="Clear Search">
                            <i class="fas fa-times"></i>
                        </button>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-weight: 500;">Search</button>
            </form>
        </div>
    <div class="card-body">
        <div class="table-wrap">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th class="text-center">Student ID</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Semester</th>
                        <th class="text-center">Enrolled Courses</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $student)
                    <tr>
                        <td>
                            <div class="user-cell">
                                @if($student->profile_image)
                                    <img src="{{ asset('storage/' . $student->profile_image) }}" alt="{{ $student->name }}" class="avatar-sm" style="object-fit: cover; border-radius: var(--radius-md); flex-shrink: 0;">
                                @else
                                    <div class="avatar-sm blue d-flex align-items-center justify-content-center text-white fw-bold">
                                        {{ strtoupper(substr($student->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="user-name">{{ $student->name }}</div>
                                    <div class="user-sub">{{ $student->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center"><span class="badge dark">{{ $student->student_id }}</span></td>
                        <td class="text-center">
                            @if($student->department)
                                <span class="badge neutral">{{ $student->department->name }}</span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($student->semester)
                                <span class="badge neutral">{{ $student->semester }}</span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @php
                                $enrolled = json_decode($student->enrolled_courses, true) ?? [];
                                $courseNames = $courses->whereIn('id', $enrolled)->pluck('course_code')->toArray();
                            @endphp
                            @if(count($courseNames) > 0)
                                <div class="d-flex flex-wrap justify-content-center gap-1">
                                    @foreach(array_slice($courseNames, 0, 3) as $code)
                                        <span class="badge info">{{ $code }}</span>
                                    @endforeach
                                    @if(count($courseNames) > 3)
                                        <span class="badge neutral" title="{{ implode(', ', array_slice($courseNames, 3)) }}">
                                            +{{ count($courseNames) - 3 }} more
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted small">No courses</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($student->is_active)
                                <span class="badge success"><i class="fas fa-check-circle"></i> Active</span>
                            @else
                                <span class="badge danger"><i class="fas fa-times-circle"></i> Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group">
                                <button class="action-btn edit edit-student-btn" 
                                    data-id="{{ $student->id }}"
                                    data-name="{{ $student->name }}"
                                    data-email="{{ $student->email }}"
                                    data-contactnumber="{{ $student->contact_number }}"
                                    data-studentid="{{ $student->student_id }}"
                                    data-semester="{{ $student->semester }}"
                                    data-department="{{ $student->department_id }}"
                                    data-isactive="{{ $student->is_active ? 1 : 0 }}"
                                    data-courses="{{ $student->enrolled_courses }}"
                                    data-image="{{ $student->profile_image ? asset('storage/' . $student->profile_image) : '' }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="{{ route('admin.student-info.destroy', $student->id) }}" method="POST" class="m-0 p-0 delete-form d-flex align-items-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="action-btn delete delete-btn"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-search fa-3x text-muted mb-3" style="opacity: 0.2;"></i>
                                @if(request('search'))
                                    <h6 class="text-heading fw-bold">No results found for "{{ request('search') }}"</h6>
                                    <p class="text-muted small">We couldn't find any student matching your search criteria.</p>
                                    <a href="{{ route('admin.student-info.index') }}" class="btn btn-sm btn-primary mt-3">Clear Search</a>
                                @else
                                    <h6 class="text-heading fw-bold">No students found</h6>
                                    <p class="text-muted small">Add your first student to see them listed here.</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 px-3 pb-3 border-top pt-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection

@push('modals')
<div class="modal fade" id="addStudentModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content premium">
                <div class="modal-head gradient"><h5 class="modal-title"><i class="fas fa-user-plus"></i> Register Student</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div>
                <div class="modal-body-content">
                    <form method="POST" action="{{ route('admin.student-info.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-4">
                            <label class="form-label d-block text-muted small mb-2">Profile Image (Optional)</label>
                            <div class="avatar-upload-container">
                                <div class="avatar-preview-box" id="add_upload_zone">
                                    <input type="file" name="profile_image" id="add_profile_image" class="d-none" accept="image/png, image/jpeg, image/gif" onchange="previewAvatar(this, 'add_preview_img', 'add_placeholder', 'add_remove_btn')">
                                    <div id="add_placeholder" onclick="document.getElementById('add_profile_image').click()">
                                        <i class="fas fa-camera"></i>
                                        <span>Upload</span>
                                    </div>
                                    <img id="add_preview_img" src="" alt="Preview" style="display: none;" onclick="document.getElementById('add_profile_image').click()">
                                    <button type="button" id="add_remove_btn" class="avatar-remove-btn" style="display: none;" onclick="removeAvatar('add_profile_image', 'add_preview_img', 'add_placeholder', 'add_remove_btn')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group"><label class="form-label">Student Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-input" placeholder="Enter full name" required></div>
                            <div class="form-group"><label class="form-label">Student ID <span class="text-danger">*</span></label><input type="text" name="student_id" class="form-input" placeholder="e.g. UG02-45-19-021" required></div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group"><label class="form-label">Email Address <span class="text-danger">*</span></label><input type="email" name="email" class="form-input" placeholder="student@example.com" required></div>
                            <div class="form-group"><label class="form-label">Contact Number</label><input type="text" name="contact_number" class="form-input" placeholder="e.g. +880 1XXX-XXXXXX"></div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group"><label class="form-label">Department</label>
                                <select class="form-select" name="department_id" id="add_department_id" placeholder="Select Department">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group"><label class="form-label">Semester / Term <span class="text-danger">*</span></label>
                                <select class="form-select" name="semester" id="add_semester" required placeholder="Select Semester">
                                    <option value="">Select Semester</option>
                                    @foreach($semesters as $sem)
                                        <option value="{{ $sem->name }}">{{ $sem->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group" style="position: relative;">
                                <label class="form-label">Set Password <span class="text-danger">*</span></label>
                                <input type="password" id="add_password" name="password" class="form-input" placeholder="Create a secure password" required minlength="8" style="padding-right: 40px;">
                                <i class="fas fa-eye toggle-password" onclick="togglePassword('add_password', this)" style="position: absolute; right: 15px; bottom: 12px; cursor: pointer; color: var(--text-muted); font-size: 0.9rem;"></i>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Account Status</label>
                                <div class="custom-switch-container">
                                    <label class="custom-switch">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1" checked>
                                        <span class="switch-slider"></span>
                                    </label>
                                    <span class="switch-label">Active</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-divider"><i class="fas fa-book-open"></i> Course Enrollment</div>
                        <div class="form-group mb-4">
                            <label class="form-label text-muted small mb-2">Search & Select Courses (Multiple)</label>
                            <select class="form-select" name="courses[]" id="add_courses" multiple placeholder="Select courses...">
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->title ?? 'Course' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="display:flex; justify-content:center; gap:12px; margin-top:24px;">
                            <button type="button" class="btn btn-light" style="padding:10px 32px; font-weight:600; border: 1px solid #cbd5e1; background-color: #f1f5f9; color: #334155; box-shadow: 0 2px 4px rgba(0,0,0,0.05);" data-bs-dismiss="modal" onmouseover="this.style.backgroundColor='#e2e8f0'" onmouseout="this.style.backgroundColor='#f1f5f9'"><i class="fas fa-times"></i> Cancel</button>
                            <button type="submit" class="btn btn-primary" style="padding:10px 48px;"><i class="fas fa-check-circle"></i> Add Student</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT STUDENT MODAL -->
    <div class="modal fade" id="editStudentModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content premium">
                <div class="modal-head dark-grad"><h5 class="modal-title"><i class="fas fa-pen"></i> Edit Student</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div>
                <div class="modal-body-content">
                    <form id="editStudentForm" method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-4">
                            <label class="form-label d-block text-muted small mb-2">Update Profile Image</label>
                            <div class="avatar-upload-container">
                                <div class="avatar-preview-box" id="edit_upload_zone">
                                    <input type="file" name="profile_image" id="edit_profile_image" class="d-none" accept="image/png, image/jpeg, image/gif" onchange="previewAvatar(this, 'edit_preview_img', 'edit_placeholder', 'edit_remove_btn')">
                                    <div id="edit_placeholder" onclick="document.getElementById('edit_profile_image').click()">
                                        <i class="fas fa-camera"></i>
                                        <span>Change</span>
                                    </div>
                                    <img id="edit_preview_img" src="" alt="Preview" style="display: none;" onclick="document.getElementById('edit_profile_image').click()">
                                    <button type="button" id="edit_remove_btn" class="avatar-remove-btn" style="display: none;" onclick="removeEditAvatar()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="remove_image" id="remove_image_hidden" value="0">
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" id="edit_name" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Student ID</label>
                                <input type="text" name="student_id" id="edit_student_id" class="form-input" required>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" id="edit_email" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Contact Number</label>
                                <input type="text" name="contact_number" id="edit_contact_number" class="form-input" placeholder="e.g. +880 1XXX-XXXXXX">
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Department</label>
                                <select class="form-select" name="department_id" id="edit_department_id" placeholder="Select Department">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Semester</label>
                                <select name="semester" id="edit_semester" class="form-select" required placeholder="Select Semester">
                                    <option value="">Select Semester</option>
                                    @foreach($semesters as $sem)
                                        <option value="{{ $sem->name }}">{{ $sem->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group" style="position: relative;">
                                <label class="form-label">Update Password</label>
                                <input type="password" id="edit_password" name="password" class="form-input" placeholder="Leave blank to keep current" style="padding-right: 40px;">
                                <i class="fas fa-eye toggle-password" onclick="togglePassword('edit_password', this)" style="position: absolute; right: 15px; bottom: 12px; cursor: pointer; color: var(--text-muted); font-size: 0.9rem;"></i>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Account Status</label>
                                <div class="custom-switch-container">
                                    <label class="custom-switch">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" id="edit_is_active" value="1">
                                        <span class="switch-slider"></span>
                                    </label>
                                    <span class="switch-label">Active</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-divider"><i class="fas fa-book-open"></i> Course Subscriptions</div>
                        <div class="form-group mb-4">
                            <label class="form-label text-muted small mb-2">Search & Select Courses (Multiple)</label>
                            <select class="form-select" name="courses[]" id="edit_courses" multiple placeholder="Select courses...">
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->title ?? 'Course' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<style>
    .avatar-upload-container {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
    }
    .btn-clear-search {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        padding: 0;
        font-size: 1rem;
        transition: color 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-clear-search:hover {
        color: #ef4444;
    }
    .avatar-preview-box {
        position: relative;
        width: 110px;
        height: 110px;
        border-radius: 50%;
        border: 3px dashed var(--border-light);
        background: rgba(255, 255, 255, 0.03);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        cursor: pointer;
    }
    .avatar-preview-box:hover {
        border-color: var(--primary);
        background: rgba(59, 130, 246, 0.05);
    }
    .avatar-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        z-index: 2;
    }
    .avatar-preview-box div {
        text-align: center;
        color: var(--text-muted);
        z-index: 1;
        position: absolute;
    }
    .avatar-preview-box div i {
        font-size: 1.5rem;
        display: block;
        margin-bottom: 5px;
    }
    .avatar-preview-box div span {
        font-size: 0.75rem;
        font-weight: 600;
    }
    .avatar-remove-btn {
        position: absolute;
        top: 0;
        right: -5px;
        background: #ef4444;
        color: white;
        border: 2px solid var(--bg-card);
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 3;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        transition: all 0.2s;
    }
    .avatar-remove-btn:hover {
        background: #dc2626;
        transform: scale(1.1);
    }
    /* Switch styles */
    .custom-switch-container { display: flex; align-items: center; gap: 10px; }
    .custom-switch { position: relative; display: inline-block; width: 48px; height: 24px; }
    .custom-switch input { opacity: 0; width: 0; height: 0; }
    .switch-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 24px; }
    .switch-slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
    input:checked + .switch-slider { background-color: var(--primary); }
    input:checked + .switch-slider:before { transform: translateX(24px); }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Choices.js replaced by TomSelect

        // Edit Modal Population
        const editButtons = document.querySelectorAll('.edit-student-btn');
        const editForm = document.getElementById('editStudentForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const imagePath = this.getAttribute('data-image');
                
                document.getElementById('edit_name').value = this.getAttribute('data-name');
                document.getElementById('edit_email').value = this.getAttribute('data-email');
                document.getElementById('edit_contact_number').value = this.getAttribute('data-contactnumber');
                document.getElementById('edit_student_id').value = this.getAttribute('data-studentid');
                
                // Update TomSelect value
                const semester = this.getAttribute('data-semester');
                if (window.editSemesterSelect) {
                    window.editSemesterSelect.setValue(semester);
                } else {
                    document.getElementById('edit_semester').value = semester;
                }
                
                const department = this.getAttribute('data-department');
                if (window.editDepartmentSelect) {
                    window.editDepartmentSelect.setValue(department);
                } else {
                    document.getElementById('edit_department_id').value = department;
                }
                
                document.getElementById('edit_is_active').checked = this.getAttribute('data-isactive') === '1';
                
                // Image Handling
                const previewImg = document.getElementById('edit_preview_img');
                const placeholder = document.getElementById('edit_placeholder');
                const removeBtn = document.getElementById('edit_remove_btn');
                
                document.getElementById('remove_image_hidden').value = "0";
                document.getElementById('edit_profile_image').value = '';

                if(imagePath) {
                    previewImg.src = imagePath;
                    previewImg.style.display = 'block';
                    placeholder.style.display = 'none';
                    removeBtn.style.display = 'flex';
                } else {
                    previewImg.src = '';
                    previewImg.style.display = 'none';
                    placeholder.style.display = 'block';
                    removeBtn.style.display = 'none';
                }
                
                // Set enrolled courses using TomSelect API
                const courses = JSON.parse(this.getAttribute('data-courses') || '[]');
                
                if (window.editCourseSelect) {
                    window.editCourseSelect.clear();
                    if(courses && courses.length > 0) {
                        window.editCourseSelect.setValue(courses.map(String));
                    }
                }
                
                // Set form action
                let actionUrl = "{{ route('admin.student-info.update', ':id') }}";
                editForm.action = actionUrl.replace(':id', id);
                
                // Show modal
                new bootstrap.Modal(document.getElementById('editStudentModal')).show();
            });
        });

        // Initialize TomSelect for Departments
        if(document.getElementById('add_department_id')) {
            let addDept = new TomSelect("#add_department_id", {
                create: false,
                controlInput: null,
                maxOptions: null,
                allowEmptyOption: true,
                wrapperClass: 'ts-wrapper form-select ts-department',
                plugins: ['dropdown_input'],
                sortField: { field: "text", direction: "asc" },
                onDelete: function(values, e) { return false; }
            });
            let searchInput = addDept.dropdown.querySelector('input');
            if(searchInput) searchInput.setAttribute('placeholder', 'Search department...');
        }
        
        if(document.getElementById('edit_department_id')) {
            window.editDepartmentSelect = new TomSelect("#edit_department_id", {
                create: false,
                controlInput: null,
                maxOptions: null,
                allowEmptyOption: true,
                wrapperClass: 'ts-wrapper form-select ts-department',
                plugins: ['dropdown_input'],
                sortField: { field: "text", direction: "asc" },
                onDelete: function(values, e) { return false; }
            });
            let searchInput = window.editDepartmentSelect.dropdown.querySelector('input');
            if(searchInput) searchInput.setAttribute('placeholder', 'Search department...');
        }

        // Initialize TomSelect for Semesters
        if(document.getElementById('add_semester')) {
            let addSem = new TomSelect("#add_semester", {
                create: false,
                controlInput: null,
                maxOptions: null,
                allowEmptyOption: true,
                wrapperClass: 'ts-wrapper form-select ts-semester',
                plugins: ['dropdown_input'],
                sortField: { field: "text", direction: "asc" },
                onDelete: function(values, e) { return false; }
            });
            let searchInput = addSem.dropdown.querySelector('input');
            if(searchInput) searchInput.setAttribute('placeholder', 'Search semester...');
        }
        
        if(document.getElementById('edit_semester')) {
            window.editSemesterSelect = new TomSelect("#edit_semester", {
                create: false,
                controlInput: null,
                maxOptions: null,
                allowEmptyOption: true,
                wrapperClass: 'ts-wrapper form-select ts-semester',
                plugins: ['dropdown_input'],
                sortField: { field: "text", direction: "asc" },
                onDelete: function(values, e) { return false; }
            });
            let searchInput = window.editSemesterSelect.dropdown.querySelector('input');
            if(searchInput) searchInput.setAttribute('placeholder', 'Search semester...');
        }

        // Initialize TomSelect for Courses (Multiple)
        if(document.getElementById('add_courses')) {
            window.addCourseSelect = new TomSelect("#add_courses", {
                plugins: ['remove_button'],
                create: false,
                maxOptions: null,
                wrapperClass: 'ts-wrapper form-select ts-course',
                sortField: { field: "text", direction: "asc" }
            });
        }
        
        if(document.getElementById('edit_courses')) {
            window.editCourseSelect = new TomSelect("#edit_courses", {
                plugins: ['remove_button'],
                create: false,
                maxOptions: null,
                wrapperClass: 'ts-wrapper form-select ts-course',
                sortField: { field: "text", direction: "asc" }
            });
        }

        // Delete Confirmation
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This student and all their data will be removed!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Yes, delete!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });


    });

    // Professional Image Preview Helper
    // Avatar Preview Helper
    function previewAvatar(input, imgId, placeholderId, removeBtnId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(imgId).src = e.target.result;
                document.getElementById(imgId).style.display = 'block';
                document.getElementById(placeholderId).style.display = 'none';
                document.getElementById(removeBtnId).style.display = 'flex';
                if(imgId === 'edit_preview_img') {
                    document.getElementById('remove_image_hidden').value = "0";
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeAvatar(inputId, previewId, placeholderId, removeBtnId) {
        document.getElementById(inputId).value = '';
        document.getElementById(previewId).src = '';
        document.getElementById(previewId).style.display = 'none';
        document.getElementById(placeholderId).style.display = 'block';
        document.getElementById(removeBtnId).style.display = 'none';
    }

    function removeEditAvatar() {
        document.getElementById('edit_profile_image').value = '';
        document.getElementById('edit_preview_img').src = '';
        document.getElementById('edit_preview_img').style.display = 'none';
        document.getElementById('edit_placeholder').style.display = 'block';
        document.getElementById('edit_remove_btn').style.display = 'none';
        document.getElementById('remove_image_hidden').value = "1";
    }

    function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);
        if(input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush
