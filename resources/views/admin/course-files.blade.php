@extends('layouts.admin')
@section('title', 'Course Files - Admin Dashboard')
@section('page-title', 'Course Materials')
@section('breadcrumb', 'Course Materials')

@section('content')
    <!-- Top Action Bar -->
    <div class="card-header" style="margin-bottom: 20px;">
        <div class="search-box">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" placeholder="Search files...">
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <i class="fas fa-cloud-upload-alt"></i> Upload New Material
        </button>
    </div>

    <!-- Materials Table -->
    <div class="data-card">
        <div class="card-body">
            <div class="table-wrap">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th>Course</th>
                            <th>Uploaded By</th>
                            <th>Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($materials as $material)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    @php
                                        $type = strtolower($material->file_type);
                                        $icon = 'fas fa-file-alt';
                                        $color = 'blue';
                                        if (in_array($type, ['pdf'])) { $icon = 'fas fa-file-pdf'; $color = 'rose'; }
                                        elseif (in_array($type, ['doc', 'docx'])) { $icon = 'fas fa-file-word'; $color = 'blue'; }
                                        elseif (in_array($type, ['xls', 'xlsx'])) { $icon = 'fas fa-file-excel'; $color = 'emerald'; }
                                        elseif (in_array($type, ['ppt', 'pptx'])) { $icon = 'fas fa-file-powerpoint'; $color = 'amber'; }
                                        elseif (in_array($type, ['zip', 'rar'])) { $icon = 'fas fa-file-archive'; $color = 'purple'; }
                                    @endphp
                                    <div class="avatar-sm {{ $color }}"><i class="{{ $icon }}"></i></div>
                                    <div>
                                        <div class="user-name">{{ $material->title }}</div>
                                        <div class="user-sub">{{ strtoupper($material->file_type) }} • {{ round($material->file_size / 1024, 2) }} KB</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="user-name">{{ $material->course->course_code ?? 'N/A' }}</div>
                                    <div class="user-sub">{{ $material->course->course_name ?? 'Unknown Course' }}</div>
                                </div>
                            </td>
                            <td>
                                @if($material->uploader)
                                    <span class="badge success"><i class="fas fa-user"></i> {{ $material->uploader->name }}</span>
                                @else
                                    <span class="badge neutral">System</span>
                                @endif
                            </td>
                            <td><span style="font-size: 13px; color: #64748b;">{{ $material->created_at->format('d M, Y h:i A') }}</span></td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="action-btn" style="background: #eff6ff; color: #3b82f6;" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <button class="action-btn edit" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editFileModal"
                                        data-id="{{ $material->id }}"
                                        data-course="{{ $material->course_id }}"
                                        data-title="{{ $material->title }}"
                                        title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <form action="{{ route('admin.course-materials.destroy', $material->id) }}" method="POST" class="m-0 p-0" style="display: flex; align-items: center;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="action-btn delete delete-btn" title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center" style="padding: 40px;">
                                <i class="fas fa-folder-open" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                                <span style="color: #64748b;">No course materials found. Upload a new file to get started.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div style="margin-top: 20px;">
                {{ $materials->links() }}
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <!-- UPLOAD MODAL -->
    <div class="modal fade" id="uploadModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content premium">
                <div class="modal-head gradient">
                    <h5 class="modal-title"><i class="fas fa-cloud-upload-alt"></i> Upload Material</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
                </div>
                <div class="modal-body-content">
                    <form method="POST" action="{{ route('admin.course-materials.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Course</label>
                            <select class="form-select" name="course_id" required>
                                <option value="" selected disabled>Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Material Title</label>
                            <input type="text" class="form-input" name="title" placeholder="Enter title" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Choose File</label>
                            <input type="file" name="file" class="form-input" style="padding: 10px;" required>
                            <small style="color:var(--text-muted);font-size:0.8rem;margin-top:4px;display:block;">Max size: 10MB. Allowed: PDF, DOCX, XLSX, PPTX, ZIP, etc.</small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-check-circle"></i> Confirm Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT FILE MODAL -->
    <div class="modal fade" id="editFileModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content premium">
                <div class="modal-head dark-grad">
                    <h5 class="modal-title"><i class="fas fa-pen"></i> Update Material</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
                </div>
                <div class="modal-body-content">
                    <form id="editForm" method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="form-label">Course</label>
                            <select class="form-select" name="course_id" id="edit_course_id" required>
                                <option value="" disabled>Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Update Title</label>
                            <input type="text" class="form-input" name="title" id="edit_title" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Replace File</label>
                            <input type="file" name="file" class="form-input" style="padding: 10px;">
                            <small style="color:var(--text-muted);font-size:0.75rem;margin-top:4px;display:block;">Leave empty if you don't want to change the file.</small>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Modal Population
        const editButtons = document.querySelectorAll('.action-btn.edit');
        const editForm = document.getElementById('editForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const courseId = this.getAttribute('data-course');
                const title = this.getAttribute('data-title');
                
                document.getElementById('edit_course_id').value = courseId;
                document.getElementById('edit_title').value = title;
                
                // Set the form action URL dynamically
                editForm.action = `/admin/course-materials/${id}`;
            });
        });

        // Delete Confirmation with SweetAlert
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
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

        // Simple Search Filter
        const searchInput = document.getElementById('searchInput');
        if(searchInput) {
            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('.premium-table tbody tr');
                
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    if(text.includes(filter)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endpush
