@extends('layouts.admin')
@section('title', 'Semesters - Admin Dashboard')
@section('page-title', 'Academic Semesters')
@section('breadcrumb', 'Semesters')

@section('content')
<div class="page-header">
    <div class="heading-group">
        <h2>Semester Management</h2>
        <p>Manage all academic semesters and their durations.</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSemesterModal">
        <i class="fas fa-plus-circle"></i> Add Semester
    </button>
</div>

<div class="data-card">
    <div class="card-header">
        <div>
            <h5 class="card-title"><i class="fas fa-calendar-alt"></i> Academic Semesters</h5>
            <p class="card-subtitle">List of all registered academic semesters</p>
        </div>
        <form action="{{ route('admin.semesters.index') }}" method="GET" class="d-flex align-items-center gap-2" id="searchForm">
            <div class="search-box position-relative">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" id="searchInput" placeholder="Search by name or year..." value="{{ request('search') }}" style="padding-right: 30px;">
                @if(request('search'))
                    <button type="button" class="btn-clear-search" onclick="window.location.href='{{ route('admin.semesters.index') }}'" title="Clear Search">
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
                        <th>Semester Name</th>
                        <th>Year</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($semesters as $semester)
                    <tr>
                        <td>
                            <div class="user-cell">
                                @php $colors = ['blue', 'purple', 'emerald', 'amber', 'rose', 'cyan', 'indigo', 'slate']; @endphp
                                <div class="avatar-sm {{ $colors[strlen($semester->name) % 8] }} d-flex align-items-center justify-content-center text-white fw-bold">
                                    {{ strtoupper(substr($semester->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="user-name">{{ $semester->name }}</div>
                                    <div class="user-sub">Academic Term</div>
                                </div>
                            </div>
                        </td>
                        <td><span style="color:var(--text-secondary);font-weight:600;">{{ $semester->year ?? 'N/A' }}</span></td>
                        <td>
                            @if($semester->start_date && $semester->end_date)
                                <span class="badge neutral"><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($semester->start_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($semester->end_date)->format('M d, Y') }}</span>
                            @elseif($semester->start_date)
                                <span class="badge neutral"><i class="fas fa-calendar"></i> Starts: {{ \Carbon\Carbon::parse($semester->start_date)->format('M d, Y') }}</span>
                            @elseif($semester->end_date)
                                <span class="badge neutral"><i class="fas fa-calendar"></i> Ends: {{ \Carbon\Carbon::parse($semester->end_date)->format('M d, Y') }}</span>
                            @else
                                <span class="text-muted small">Not specified</span>
                            @endif
                        </td>
                        <td>
                            @if($semester->is_active)
                                <span class="badge success"><i class="fas fa-check-circle"></i> Active</span>
                            @else
                                <span class="badge danger"><i class="fas fa-times-circle"></i> Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group">
                                <button class="action-btn edit edit-semester-btn" data-bs-toggle="modal" data-bs-target="#editSemesterModal"
                                    data-id="{{ $semester->id }}"
                                    data-name="{{ $semester->name }}"
                                    data-year="{{ $semester->year }}"
                                    data-start="{{ $semester->start_date }}"
                                    data-end="{{ $semester->end_date }}"
                                    data-active="{{ $semester->is_active ? 1 : 0 }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="{{ route('admin.semesters.destroy', $semester->id) }}" method="POST" class="m-0 p-0 delete-form d-flex align-items-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="action-btn delete delete-btn"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-search fa-3x text-muted mb-3" style="opacity: 0.2;"></i>
                                @if(request('search'))
                                    <h6 class="text-heading fw-bold">No results found for "{{ request('search') }}"</h6>
                                    <p class="text-muted small">We couldn't find any semester matching your criteria.</p>
                                    <a href="{{ route('admin.semesters.index') }}" class="btn btn-sm btn-primary mt-3">Clear Search</a>
                                @else
                                    <h6 class="text-heading fw-bold">No semesters found</h6>
                                    <p class="text-muted small">Add your first academic semester to get started.</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($semesters->hasPages())
            <div class="px-4 py-3 border-top">
                {{ $semesters->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('modals')
<!-- ADD SEMESTER MODAL -->
<div class="modal fade" id="addSemesterModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content premium">
            <div class="modal-head gradient">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Add Semester</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <form action="{{ route('admin.semesters.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Semester Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-input" placeholder="Enter Semester Name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Year</label>
                        <input type="number" name="year" class="form-input" placeholder="Enter Year" min="2000" max="2100">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-input">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-input">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="is_active" class="form-select" required>
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" style="margin-top:4px;">
                        <i class="fas fa-check-circle"></i> Save Semester
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT SEMESTER MODAL -->
<div class="modal fade" id="editSemesterModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content premium">
            <div class="modal-head dark-grad">
                <h5 class="modal-title"><i class="fas fa-pen"></i> Edit Semester</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <form id="editSemesterForm" action="" method="POST">
                    @csrf 
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label">Semester Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-input" placeholder="Enter Semester Name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Year</label>
                        <input type="number" name="year" id="edit_year" class="form-input" placeholder="Enter Year" min="2000" max="2100">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="edit_start" class="form-input">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" id="edit_end" class="form-input">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="is_active" id="edit_is_active" class="form-select" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Modal Population
        const editButtons = document.querySelectorAll('.edit-semester-btn');
        const editForm = document.getElementById('editSemesterForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('edit_name').value = this.getAttribute('data-name');
                document.getElementById('edit_year').value = this.getAttribute('data-year');
                document.getElementById('edit_start').value = this.getAttribute('data-start');
                document.getElementById('edit_end').value = this.getAttribute('data-end');
                document.getElementById('edit_is_active').value = this.getAttribute('data-active');
                
                let actionUrl = "{{ route('admin.semesters.update', ':id') }}";
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
                    text: "This semester will be permanently deleted!",
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
