@extends('layouts.admin')
@section('title', 'Courses - Admin Dashboard')
@section('page-title', 'Course Information')
@section('breadcrumb', 'Course Information')

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
    .ts-wrapper.form-select { padding: 0 !important; border: none !important; background: transparent !important; box-shadow: none !important; }
    .ts-control { border: 1.5px solid var(--border) !important; border-radius: var(--radius-md) !important; background: var(--bg-input) !important; color: var(--text-body) !important; font-size: 0.85rem !important; padding: 9px 13px !important; min-height: 42px !important; box-shadow: var(--shadow-sm) !important; display: flex; flex-wrap: wrap; align-items: center; gap: 4px; transition: all var(--duration-base) var(--ease); }
    .ts-wrapper.focus .ts-control { border-color: var(--primary) !important; box-shadow: 0 0 0 3px var(--primary-glow) !important; background: white !important; outline: none !important; }
    .ts-wrapper:not(.has-items) .ts-control::before { content: "Choose Department"; display: block !important; color: var(--text-secondary) !important; font-weight: 500 !important; }
    .ts-control .item[data-value=""] { display: block !important; opacity: 1 !important; visibility: visible !important; color: var(--text-secondary) !important; font-weight: 500 !important; }
    .ts-wrapper:not(.has-items) .ts-control .item[data-value=""] { display: none !important; }
    .ts-dropdown { border: 1px solid var(--border) !important; border-radius: var(--radius-md) !important; background-color: white !important; box-shadow: var(--shadow-md) !important; z-index: 9999 !important; }
    .ts-dropdown .ts-dropdown-content { max-height: 250px !important; overflow-y: auto !important; padding-bottom: 5px; }
    .ts-dropdown .option[data-value=""] { display: none !important; }
    .ts-dropdown .option { padding: 8px 14px !important; color: var(--text-body) !important; font-size: 0.85rem !important; }
    .ts-dropdown .option:hover, .ts-dropdown .active { background-color: var(--bg-muted) !important; color: var(--primary) !important; }
    .ts-dropdown .dropdown-input-wrap { padding: 8px !important; border-bottom: 1px solid var(--border-light) !important; }
    .ts-dropdown .dropdown-input { border: 1px solid var(--border) !important; border-radius: var(--radius-sm) !important; padding: 6px 12px !important; background: var(--bg-muted) !important; color: var(--text-body) !important; font-size: 0.85rem !important; }
    .ts-control::after { content: ""; display: block; width: 10px; height: 10px; border-right: 2px solid #888; border-bottom: 2px solid #888; transform: rotate(45deg); position: absolute; right: 15px; top: 40%; transition: transform 0.2s ease; }
    .ts-wrapper.dropdown-active .ts-control::after { transform: rotate(-135deg); top: 45%; }
    .ts-wrapper.dropdown-active .ts-control .item, .ts-wrapper.has-items .ts-control .item { display: block !important; opacity: 1 !important; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="heading-group"><h2>Course Registry</h2><p>Manage courses, codes, and department allocations.</p></div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal"><i class="fas fa-plus-circle"></i> Add Course</button>
</div>

<div class="data-card">
    <div class="card-header">
        <div><h5 class="card-title"><i class="fas fa-book-open"></i> Available Courses</h5><p class="card-subtitle">All registered courses with department info</p></div>
        <form action="{{ route('admin.courses.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2" id="searchForm">
            <div class="search-box position-relative flex-grow-1">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" id="searchInput" placeholder="Search by title, subtitle, dept or status..." value="{{ request('search') }}" style="padding-right: 30px;">
                @if(request('search'))
                    <button type="button" class="btn-clear-search" onclick="window.location.href='{{ route('admin.courses.index') }}'" title="Clear Search">
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
                <thead><tr><th>Course Code</th><th>Course Title</th><th>Course Subtitle</th><th class="text-center">Department</th><th class="text-center">Status</th><th class="text-center">Action</th></tr></thead>
                <tbody>
                    @forelse($courses as $course)
                    <tr>
                        <td><span class="badge dark"><i class="fas fa-hashtag"></i> {{ $course->course_code }}</span></td>
                        <td>
                            <div class="user-name">{{ $course->title }}</div>
                        </td>
                        <td>
                            <span style="color:var(--text-secondary); font-size:0.85rem;">{{ $course->subtitle ?? 'N/A' }}</span>
                        </td>
                        <td class="text-center">
                            @php $deptColors = ['info', 'warning', 'success', 'dark', 'neutral']; @endphp
                            <span class="badge {{ $deptColors[strlen($course->department?->name ?? 'A') % count($deptColors)] }}">
                                <i class="fas fa-building-columns"></i> {{ $course->department?->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($course->is_active)
                                <span class="badge success"><i class="fas fa-check-circle"></i> Active</span>
                            @else
                                <span class="badge danger"><i class="fas fa-times-circle"></i> Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group">
                                <button class="action-btn edit edit-course-btn" data-bs-toggle="modal" data-bs-target="#editCourseModal"
                                    data-id="{{ $course->id }}"
                                    data-code="{{ $course->course_code }}"
                                    data-title="{{ $course->title }}"
                                    data-subtitle="{{ $course->subtitle }}"
                                    data-status="{{ $course->is_active ? '1' : '0' }}"
                                    data-department="{{ $course->department_id }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="m-0 p-0 delete-form d-flex align-items-center">
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
                                    <p class="text-muted small">We couldn't find any course matching your criteria.</p>
                                    <a href="{{ route('admin.courses.index') }}" class="btn btn-sm btn-primary mt-3">Clear Search</a>
                                @else
                                    <h6 class="text-heading fw-bold">No courses found</h6>
                                    <p class="text-muted small">Add your first course to get started.</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($courses->hasPages())
            <div class="px-4 py-3 border-top">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('modals')
<div class="modal fade" id="addCourseModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content premium"><div class="modal-head gradient"><h5 class="modal-title"><i class="fas fa-plus-circle"></i> Register Course</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content">
    <form action="{{ route('admin.courses.store') }}" method="POST">
        @csrf
        <div class="form-group"><label class="form-label">Course Code <span class="text-danger">*</span></label><input type="text" name="course_code" class="form-input" placeholder="e.g. CSE-201" required></div>
        <div class="form-group"><label class="form-label">Course Title <span class="text-danger">*</span></label><input type="text" name="title" class="form-input" placeholder="e.g. Object Oriented Programming" required></div>
        <div class="form-group"><label class="form-label">Course Subtitle</label><input type="text" name="subtitle" class="form-input" placeholder="e.g. Theory + Lab"></div>
        <div class="form-group"><label class="form-label">Status</label>
            <div class="custom-switch-container" style="margin-top: 8px;">
                <label class="custom-switch">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <span class="switch-slider"></span>
                </label>
                <span class="switch-label text-muted small fw-bold">Active</span>
            </div>
        </div>
        <div class="form-group"><label class="form-label">Department</label>
            <select name="department_id" id="add_department" class="form-select" placeholder="Choose Department">
                <option value="">Choose Department</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>
        <div style="display:flex; justify-content:center; gap:12px; margin-top:24px;">
            <button type="button" class="btn btn-light" style="padding:10px 32px; font-weight:600; border: 1px solid #cbd5e1; background-color: #f1f5f9; color: #334155; box-shadow: 0 2px 4px rgba(0,0,0,0.05);" data-bs-dismiss="modal" onmouseover="this.style.backgroundColor='#e2e8f0'" onmouseout="this.style.backgroundColor='#f1f5f9'"><i class="fas fa-times"></i> Cancel</button>
            <button type="submit" class="btn btn-primary" style="padding:10px 48px;"><i class="fas fa-check-circle"></i> Add Course</button>
        </div>
    </form>
</div></div></div></div>

<!-- EDIT COURSE -->
<div class="modal fade" id="editCourseModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content premium"><div class="modal-head dark-grad"><h5 class="modal-title"><i class="fas fa-pen"></i> Edit Course</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content">
    <form id="editCourseForm" action="" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group"><label class="form-label">Course Code <span class="text-danger">*</span></label><input type="text" name="course_code" id="edit_code" class="form-input" required></div>
        <div class="form-group"><label class="form-label">Course Title <span class="text-danger">*</span></label><input type="text" name="title" id="edit_title" class="form-input" required></div>
        <div class="form-group"><label class="form-label">Course Subtitle</label><input type="text" name="subtitle" id="edit_subtitle" class="form-input"></div>
        <div class="form-group"><label class="form-label">Status</label>
            <div class="custom-switch-container" style="margin-top: 8px;">
                <label class="custom-switch">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="edit_status" value="1">
                    <span class="switch-slider"></span>
                </label>
                <span class="switch-label text-muted small fw-bold">Active</span>
            </div>
        </div>
        <div class="form-group"><label class="form-label">Department</label>
            <select name="department_id" id="edit_department" class="form-select" placeholder="Choose Department">
                <option value="">Choose Department</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>
        <div style="display:flex; justify-content:center; gap:12px; margin-top:24px;">
            <button type="button" class="btn btn-light" style="padding:10px 32px; font-weight:600; border: 1px solid #cbd5e1; background-color: #f1f5f9; color: #334155; box-shadow: 0 2px 4px rgba(0,0,0,0.05);" data-bs-dismiss="modal" onmouseover="this.style.backgroundColor='#e2e8f0'" onmouseout="this.style.backgroundColor='#f1f5f9'"><i class="fas fa-times"></i> Cancel</button>
            <button type="submit" class="btn btn-primary" style="padding:10px 48px;"><i class="fas fa-check-circle"></i> Update Course</button>
        </div>
    </form>
</div></div></div></div>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize TomSelect with dropdown_input plugin
        let tsConfig = {
            create: false,
            controlInput: null,
            maxOptions: null,
            allowEmptyOption: true,
            wrapperClass: 'ts-wrapper form-select',
            plugins: ['dropdown_input'],
            sortField: { field: "text", direction: "asc" }
        };

        let addDeptSelect = new TomSelect('#add_department', tsConfig);
        let searchInputAdd = addDeptSelect.dropdown.querySelector('input');
        if(searchInputAdd) searchInputAdd.setAttribute('placeholder', 'Search department...');
        
        let editDeptSelect = new TomSelect('#edit_department', tsConfig);
        let searchInputEdit = editDeptSelect.dropdown.querySelector('input');
        if(searchInputEdit) searchInputEdit.setAttribute('placeholder', 'Search department...');

        // Edit Modal Population
        const editButtons = document.querySelectorAll('.edit-course-btn');
        const editForm = document.getElementById('editCourseForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('edit_code').value = this.getAttribute('data-code');
                document.getElementById('edit_title').value = this.getAttribute('data-title');
                document.getElementById('edit_subtitle').value = this.getAttribute('data-subtitle');
                document.getElementById('edit_status').checked = this.getAttribute('data-status') === '1';
                
                // Update TomSelect value
                editDeptSelect.setValue(this.getAttribute('data-department'));
                
                let actionUrl = "{{ route('admin.courses.update', ':id') }}";
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
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Yes, delete it!'
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

        @if(session('success'))
            Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
        @endif
        @if(session('error'))
            Toast.fire({ icon: 'error', title: "{{ session('error') }}" });
        @endif
        @if($errors->any())
            Toast.fire({ icon: 'error', title: "Validation Error", text: "{{ $errors->first() }}" });
        @endif
    });
</script>
@endpush
