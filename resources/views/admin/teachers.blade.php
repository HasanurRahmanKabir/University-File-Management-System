@extends('layouts.admin')
@section('title', 'Teachers - Admin Dashboard')
@section('page-title', 'Teacher Management')
@section('breadcrumb', 'Teacher Management')

@section('content')
<div class="page-header">
    <div class="heading-group"><h2>Faculty Members</h2><p>Manage teachers, departments, and course assignments.</p></div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeacherModal"><i class="fas fa-user-plus"></i> Add Teacher</button>
</div>

    <!-- Stats Row -->
    <div class="stats-grid grid-3">
        <div class="stat-card {{ !request()->has('status') || request('status') == '' ? 'active-filter' : '' }}" onclick="window.location.href='{{ route('admin.teacher-info.index') }}'" style="cursor: pointer;" title="View All Faculty">
            <div class="stat-icon-wrap blue"><i class="fas fa-chalkboard-teacher"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total Faculty</div>
                <div class="stat-number">{{ $totalTeachers ?? 0 }}</div>
                <div class="stat-trend up"><i class="fas fa-users"></i> Registered</div>
            </div>
        </div>
        <div class="stat-card {{ request('status') == 'active' ? 'active-filter' : '' }}" onclick="window.location.href='{{ route('admin.teacher-info.index', ['status' => 'active']) }}'" style="cursor: pointer;" title="View Active Faculty">
            <div class="stat-icon-wrap emerald"><i class="fas fa-user-check"></i></div>
            <div class="stat-info">
                <div class="stat-label">Active Faculty</div>
                <div class="stat-number">{{ $activeTeachers ?? 0 }}</div>
                <div class="stat-trend neutral"><i class="fas fa-check"></i> Active</div>
            </div>
        </div>
        <div class="stat-card {{ request('status') == 'inactive' ? 'active-filter' : '' }}" onclick="window.location.href='{{ route('admin.teacher-info.index', ['status' => 'inactive']) }}'" style="cursor: pointer;" title="View Inactive Faculty">
            <div class="stat-icon-wrap amber"><i class="fas fa-user-times"></i></div>
            <div class="stat-info">
                <div class="stat-label">Inactive</div>
                <div class="stat-number">{{ $inactiveTeachers ?? 0 }}</div>
                <div class="stat-trend down"><i class="fas fa-clock"></i> Pending/Inactive</div>
            </div>
        </div>
    </div>

<div class="data-card">
    <div class="card-header">
        <div><h5 class="card-title"><i class="fas fa-chalkboard-teacher"></i> Faculty List</h5><p class="card-subtitle">All registered teachers with department info</p></div>
        <form action="{{ route('admin.teacher-info.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-wrap" id="searchForm">
            @if(request()->has('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <select name="department_id" class="form-select m-0" style="width: auto; min-width: 150px; height: 38px;" onchange="this.form.submit()">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                @endforeach
            </select>

            <div class="search-box position-relative m-0" style="height: 38px;">
                <i class="fas fa-search search-icon" style="top: 50%; transform: translateY(-50%);"></i>
                <input type="text" name="search" id="searchInput" placeholder="Search any field..." value="{{ request('search') }}" style="height: 100%; border-radius: var(--radius-md); padding-right: 30px;">
            </div>
            
            <button type="submit" class="btn btn-primary m-0" style="padding: 0 16px; font-weight: 500; height: 38px; display: flex; align-items: center;">Search</button>

            @if(request('search') || request('department_id'))
                <a href="{{ route('admin.teacher-info.index', request()->has('status') ? ['status' => request('status')] : []) }}" class="btn-reset-filter m-0" title="Clear Filters">
                    <i class="fas fa-rotate-left"></i> Reset
                </a>
            @endif
        </form>
    </div>
    <div class="card-body"><div class="table-wrap">
        <table class="premium-table">
            <thead>
                <tr>
                    <th><div style="min-width: 200px; display: inline-block;">Teacher Name</div></th>
                    <th><div style="min-width: 180px; display: inline-block; text-align: center;">Email</div></th>
                    <th><div style="min-width: 150px; display: inline-block; text-align: center;">Department</div></th>
                    <th><div style="min-width: 120px; display: inline-block; text-align: center;">Status</div></th>
                    <th><div style="min-width: 160px; display: inline-block; text-align: center;">Offered Courses</div></th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $teacher)
                <tr>
                    <td>
                        <div class="user-cell" style="min-width: 200px;">
                            @if($teacher->profile_image)
                                <img src="{{ asset('storage/' . $teacher->profile_image) }}" alt="{{ $teacher->name }}" class="avatar-sm" style="object-fit: cover; border-radius: var(--radius-md); flex-shrink: 0;">
                            @else
                                <div class="avatar-sm purple d-flex align-items-center justify-content-center text-white fw-bold">
                                    {{ strtoupper(substr($teacher->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <div class="user-name">{{ $teacher->name }}</div>
                                <div class="user-sub">{{ $teacher->designation ?? 'Faculty Member' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="min-width: 180px; display: inline-block; text-align: center;">
                            <span style="color:var(--text-secondary); font-size:0.82rem;">{{ $teacher->email }}</span>
                        </div>
                    </td>
                    <td>
                        <div style="min-width: 150px; display: inline-block; text-align: center;">
                            @if($teacher->department)
                                <span class="badge primary"><i class="fas fa-building-columns"></i> {{ $teacher->department->name }}</span>
                            @else
                                <span class="badge neutral"><i class="fas fa-building-columns"></i> Not Assigned</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div style="min-width: 120px; display: inline-block; text-align: center;">
                            @if($teacher->is_active)
                                <span class="badge success"><i class="fas fa-check-circle"></i> Active</span>
                            @else
                                <span class="badge danger"><i class="fas fa-times-circle"></i> Inactive</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div style="min-width: 160px; display: flex; flex-wrap: wrap; justify-content: center; gap: 4px; margin: 0 auto;">
                            @forelse($teacher->courses as $course)
                                <span class="badge success">{{ $course->course_code }}</span>
                            @empty
                                <span class="text-muted" style="font-size: 0.8rem;">No courses assigned</span>
                            @endforelse
                        </div>
                    </td>
                    <td>
                        <div class="action-group justify-content-center">
                            <button class="action-btn edit edit-teacher-btn" data-bs-toggle="modal" data-bs-target="#editTeacherModal"
                                data-id="{{ $teacher->id }}"
                                data-name="{{ $teacher->name }}"
                                data-email="{{ $teacher->email }}"
                                data-department="{{ $teacher->department_id }}"
                                data-designation="{{ $teacher->designation }}"
                                data-active="{{ $teacher->is_active ? 1 : 0 }}"
                                data-profile-image="{{ $teacher->profile_image }}"
                                data-courses="{{ json_encode($teacher->courses->pluck('id')->toArray()) }}">
                                <i class="fas fa-pen"></i>
                            </button>
                            <form action="{{ route('admin.teacher-info.destroy', $teacher->id) }}" method="POST" class="m-0 p-0 delete-form d-flex align-items-center">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="action-btn delete delete-btn"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-search fa-3x text-muted mb-3" style="opacity: 0.2;"></i>
                            @if(request('search'))
                                <h6 class="text-heading fw-bold">No results found for "{{ request('search') }}"</h6>
                                <p class="text-muted small">We couldn't find any teacher matching your search criteria.</p>
                                <a href="{{ route('admin.teacher-info.index') }}" class="btn btn-sm btn-primary mt-3">Clear Search</a>
                            @else
                                <h6 class="text-heading fw-bold">No teachers found</h6>
                                <p class="text-muted small">Add your first teacher to see them listed here.</p>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
        <div class="mt-3 px-3 pb-3 border-top pt-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    @endif
    </div>
</div>
@endsection

@push('modals')
    <!-- ADD TEACHER -->
    <div class="modal fade" id="addTeacherModal" tabindex="-1"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content premium"><div class="modal-head gradient"><h5 class="modal-title"><i class="fas fa-user-plus"></i> Register Teacher</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form action="{{ route('admin.teacher-info.store') }}" method="POST" enctype="multipart/form-data">@csrf
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
        <div class="form-grid"><div class="form-group"><label class="form-label">Full Name</label><input type="text" name="name" class="form-input" placeholder="Enter full name" required></div><div class="form-group"><label class="form-label">Email Address</label><input type="email" name="email" class="form-input" placeholder="example@univ.edu" required></div></div>
        <div class="form-grid">
            <div class="form-group"><label class="form-label">Department</label><select name="department_id" id="add_department_id" class="form-select" placeholder="Select Department"><option value="">Select Department</option>@foreach($departments as $dept)<option value="{{ $dept->id }}">{{ $dept->name }}</option>@endforeach</select></div>
            <div class="form-group"><label class="form-label">Designation</label><input type="text" name="designation" class="form-input" placeholder="e.g. Senior Lecturer"></div>
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Set Password <span class="text-danger">*</span></label>
                <div style="position: relative;">
                    <input type="password" name="password" class="form-input" placeholder="Create secure password" required minlength="8" style="padding-right: 40px;">
                    <i class="fas fa-eye toggle-pwd" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-muted);"></i>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Account Status</label>
                <div class="custom-switch-container" style="margin-top: 8px;">
                    <label class="custom-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span class="switch-slider"></span>
                    </label>
                    <span class="switch-label text-muted small fw-bold">Active</span>
                </div>
            </div>
        </div>
        <div class="form-divider"><i class="fas fa-book-open"></i> Offer Courses</div>
        <div class="form-group mb-4 px-3">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-2 gap-2">
                <label class="form-label text-muted small mb-0">Search & Select Courses (Multiple)</label>
                <div class="custom-switch-container d-flex align-items-center gap-2">
                    <span class="text-muted small fw-bold">Allow Cross-Department</span>
                    <label class="custom-switch m-0" style="transform: scale(0.85); transform-origin: right;">
                        <input type="checkbox" id="add_cross_dept_toggle">
                        <span class="switch-slider"></span>
                    </label>
                </div>
            </div>
            <select class="form-select" id="add_courses" name="courses[]" multiple placeholder="Select courses">
                <option value="">Select Courses</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" data-department-id="{{ $course->department_id }}">{{ $course->course_code }} - {{ $course->title ?? 'Course' }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-actions">
            <button type="button" class="btn btn-ghost" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
            <button type="submit" class="btn btn-primary" ><i class="fas fa-check-circle"></i> Register</button>
        </div>
    </form></div></div></div></div>

    <!-- EDIT TEACHER MODAL -->
    <div class="modal fade" id="editTeacherModal" tabindex="-1"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content premium"><div class="modal-head dark-grad"><h5 class="modal-title"><i class="fas fa-pen"></i> Edit Teacher</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form id="editTeacherForm" action="" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
        <input type="hidden" name="remove_image" id="remove_image_hidden" value="0">
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
        </div>
        <div class="form-grid"><div class="form-group"><label class="form-label">Full Name</label><input type="text" name="name" id="edit_name" class="form-input" required></div><div class="form-group"><label class="form-label">Email</label><input type="email" name="email" id="edit_email" class="form-input" required></div></div>
        <div class="form-grid">
            <div class="form-group"><label class="form-label">Department</label><select name="department_id" id="edit_department_id" class="form-select" placeholder="Select Department"><option value="">Select Department</option>@foreach($departments as $dept)<option value="{{ $dept->id }}">{{ $dept->name }}</option>@endforeach</select></div>
            <div class="form-group"><label class="form-label">Designation</label><input type="text" name="designation" id="edit_designation" class="form-input" placeholder="e.g. Professor"></div>
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">New Password</label>
                <div style="position: relative;">
                    <input type="password" name="password" class="form-input" placeholder="Leave blank if no change" minlength="8" style="padding-right: 40px;">
                    <i class="fas fa-eye toggle-pwd" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-muted);"></i>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Account Status</label>
                <div class="custom-switch-container" style="margin-top: 8px;">
                    <label class="custom-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="edit_is_active" value="1">
                        <span class="switch-slider"></span>
                    </label>
                    <span class="switch-label text-muted small fw-bold">Active</span>
                </div>
            </div>
        </div>
        <div class="form-divider"><i class="fas fa-book-open"></i> Offer Courses</div>
        <div class="form-group mb-4 px-3">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-2 gap-2">
                <label class="form-label text-muted small mb-0">Search & Select Courses (Multiple)</label>
                <div class="custom-switch-container d-flex align-items-center gap-2">
                    <span class="text-muted small fw-bold">Allow Cross-Department</span>
                    <label class="custom-switch m-0" style="transform: scale(0.85); transform-origin: right;">
                        <input type="checkbox" id="edit_cross_dept_toggle">
                        <span class="switch-slider"></span>
                    </label>
                </div>
            </div>
            <select class="form-select edit-course-select" id="edit_courses" name="courses[]" multiple placeholder="Select courses">
                <option value="">Select Courses</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" data-department-id="{{ $course->department_id }}">{{ $course->course_code }} - {{ $course->title ?? 'Course' }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-actions">
            <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Save Changes</button>
        </div>
    </form></div></div></div></div>
@endpush

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<style>
    .avatar-upload-container {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
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
    /* Clean TomSelect styling for Department */
    .ts-wrapper.ts-department {
        padding: 0 !important;
        border: none !important;
        background-color: transparent !important;
        box-shadow: none !important;
    }
    .ts-wrapper.ts-department .ts-control {
        border: 1.5px solid var(--border) !important;
        border-radius: var(--radius-md) !important;
        background-color: var(--bg-input) !important;
        color: var(--text-body) !important;
        font-size: 0.85rem !important;
        padding: 9px 30px 9px 13px !important; /* Right padding for arrow */
        min-height: 42px !important;
        box-shadow: none !important;
        display: flex;
        align-items: center;
        transition: all var(--duration-base) var(--ease);
        cursor: pointer;
    }
    .ts-wrapper.ts-department.focus .ts-control {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px var(--primary-glow) !important;
        background-color: white !important;
    }
    /* Fix Placeholder */
    .ts-wrapper.ts-department .ts-control .item[data-value=""] {
        color: var(--text-muted) !important;
    }
    
    /* TomSelect styling for Course (Multiple) */
    .ts-wrapper.ts-course {
        padding: 0 !important;
        border: none !important;
        background-color: transparent !important;
        box-shadow: none !important;
    }
    .ts-wrapper.ts-course .ts-control {
        border: 1.5px solid var(--border) !important;
        border-radius: var(--radius-md) !important;
        background-color: var(--bg-input) !important;
        color: var(--text-body) !important;
        font-size: 0.85rem !important;
        padding: 9px 30px 9px 13px !important; /* Right padding for arrow */
        min-height: 48px !important;
        box-shadow: none !important;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 6px;
        transition: all var(--duration-base) var(--ease);
        cursor: pointer;
    }
    .ts-wrapper.ts-course.focus .ts-control {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px var(--primary-glow) !important;
        background-color: white !important;
    }

    /* CLEAR, LARGE DROPDOWN ARROW INDICATOR */
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
    }

    /* Switch styles */
    .custom-switch-container { display: flex; align-items: center; gap: 10px; }
    .custom-switch { position: relative; display: inline-block; width: 48px; height: 24px; }
    .custom-switch input { opacity: 0; width: 0; height: 0; }
    .switch-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .4s; border-radius: 24px; }
    .switch-slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
    input:checked + .switch-slider { background-color: var(--primary); }
    input:checked + .switch-slider:before { transform: translateX(24px); }
</style>
<!-- Choices.js CSS & JS for Premium Multi-Select -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password Visibility Toggle
        const togglePwds = document.querySelectorAll('.toggle-pwd');
        togglePwds.forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });
        });

        const allCourses = [
            @foreach($courses as $course)
            { value: "{{ $course->id }}", text: "{{ $course->course_code }} - {{ $course->title ?? 'Course' }}", department_id: "{{ $course->department_id }}" },
            @endforeach
        ];

        function filterCourses(tsInstance, departmentId, allowCrossDept) {
            if(!tsInstance) return;
            const currentVal = tsInstance.getValue();
            let selectedArray = [];
            
            if (Array.isArray(currentVal)) {
                selectedArray = currentVal;
            } else if (typeof currentVal === 'string' && currentVal.trim() !== '') {
                // TomSelect might return a comma separated string for multiple selects
                selectedArray = currentVal.split(',');
            }
            
            selectedArray = selectedArray.map(item => item.toString());

            tsInstance.clearOptions();
            allCourses.forEach(course => {
                const isSelected = selectedArray.includes(course.value.toString());
                if (isSelected || allowCrossDept || !departmentId || course.department_id == departmentId) {
                    tsInstance.addOption(course);
                }
            });
            tsInstance.setValue(selectedArray, true);
        }

        // Initialize TomSelect for Courses (Multiple)
        if(document.getElementById('add_courses')) {
            window.addCourseSelect = new TomSelect("#add_courses", {
                plugins: ['remove_button'],
                create: false,
                maxOptions: null,
                wrapperClass: 'ts-wrapper form-select ts-course',
                sortField: { field: "text", direction: "asc" },
                valueField: 'value',
                labelField: 'text',
                searchField: 'text',
                options: allCourses
            });
        }
        
        if(document.getElementById('edit_courses')) {
            window.editCourseSelect = new TomSelect("#edit_courses", {
                plugins: ['remove_button'],
                create: false,
                maxOptions: null,
                wrapperClass: 'ts-wrapper form-select ts-course',
                sortField: { field: "text", direction: "asc" },
                valueField: 'value',
                labelField: 'text',
                searchField: 'text',
                options: allCourses
            });
        }

        // Initialize TomSelect for Department
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

            const toggle = document.getElementById('add_cross_dept_toggle');
            
            addDept.on('change', function(val) {
                filterCourses(window.addCourseSelect, val, toggle.checked);
            });
            toggle.addEventListener('change', function() {
                filterCourses(window.addCourseSelect, addDept.getValue(), this.checked);
            });
        }
        
        if(document.getElementById('edit_department_id')) {
            window.editDeptSelect = new TomSelect("#edit_department_id", {
                create: false,
                controlInput: null,
                maxOptions: null,
                allowEmptyOption: true,
                wrapperClass: 'ts-wrapper form-select ts-department',
                plugins: ['dropdown_input'],
                sortField: { field: "text", direction: "asc" },
                onDelete: function(values, e) { return false; }
            });
            let searchInput = window.editDeptSelect.dropdown.querySelector('input');
            if(searchInput) searchInput.setAttribute('placeholder', 'Search department...');

            const toggle = document.getElementById('edit_cross_dept_toggle');
            
            window.editDeptSelect.on('change', function(val) {
                filterCourses(window.editCourseSelect, val, toggle.checked);
            });
            toggle.addEventListener('change', function() {
                filterCourses(window.editCourseSelect, window.editDeptSelect.getValue(), this.checked);
            });
        }

        // Edit Modal Population
        const editButtons = document.querySelectorAll('.edit-teacher-btn');
        const editForm = document.getElementById('editTeacherForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('edit_name').value = this.getAttribute('data-name');
                document.getElementById('edit_email').value = this.getAttribute('data-email');
                const deptId = this.getAttribute('data-department');
                if (window.editDeptSelect) {
                    window.editDeptSelect.setValue(deptId);
                } else {
                    document.getElementById('edit_department_id').value = deptId;
                }
                document.getElementById('edit_designation').value = this.getAttribute('data-designation');
                document.getElementById('edit_is_active').checked = this.getAttribute('data-active') === '1';
                // Set courses using TomSelect API
                const courseStr = this.getAttribute('data-courses');
                let courses = [];
                try { courses = JSON.parse(courseStr); } catch(e){}
                
                if (window.editCourseSelect) {
                    // Check if any assigned course belongs to a different department
                    let hasCrossDept = false;
                    courses.forEach(courseId => {
                        let courseObj = allCourses.find(c => c.value == courseId);
                        if(courseObj && courseObj.department_id != deptId) {
                            hasCrossDept = true;
                        }
                    });

                    const toggle = document.getElementById('edit_cross_dept_toggle');
                    toggle.checked = hasCrossDept;
                    
                    // Filter courses based on department and cross-dept status before setting value
                    filterCourses(window.editCourseSelect, deptId, hasCrossDept);

                    window.editCourseSelect.clear();
                    if(courses.length > 0) {
                        window.editCourseSelect.setValue(courses.map(c => c.toString()));
                    }
                }
                
                // Set form action
                let actionUrl = "{{ route('admin.teacher-info.update', ':id') }}";
                editForm.action = actionUrl.replace(':id', id);

                // Set Profile Picture
                const profileImg = this.getAttribute('data-profile-image');
                document.getElementById('remove_image_hidden').value = "0";
                if (profileImg) {
                    document.getElementById('edit_preview_img').src = '/storage/' + profileImg;
                    document.getElementById('edit_preview_img').style.display = 'block';
                    document.getElementById('edit_placeholder').style.display = 'none';
                    document.getElementById('edit_remove_btn').style.display = 'flex';
                } else {
                    document.getElementById('edit_preview_img').src = '';
                    document.getElementById('edit_preview_img').style.display = 'none';
                    document.getElementById('edit_placeholder').style.display = 'block';
                    document.getElementById('edit_remove_btn').style.display = 'none';
                }
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
                    text: "This teacher and all their data will be removed!",
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
        // Toast Notifications
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            background: 'var(--bg-card)',
            color: 'var(--text-heading)',
            customClass: { popup: 'premium-toast' }
        });

    });

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
</script>
@endpush

