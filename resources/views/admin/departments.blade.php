@extends('layouts.admin')
@section('title', 'Departments - Admin Dashboard')
@section('page-title', 'Departments')
@section('breadcrumb', 'Departments')

@section('content')
<div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div class="heading-group">
        <h2>Academic Departments</h2>
        <p>Manage main faculties and administrative departments.</p>
    </div>
    <div style="display:flex; gap:8px; margin-right: 15px;">
        <button class="btn btn-primary mt-2 mt-sm-0" data-bs-toggle="modal" data-bs-target="#addDeptModal">
            <i class="fas fa-plus-circle"></i> Add Department
        </button>
    </div>
</div>

<div class="data-card">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5 class="card-title"><i class="fas fa-building-columns"></i> Faculty List</h5>
            <p class="card-subtitle">All active university departments</p>
        </div>
        <form action="{{ route('admin.departments.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2" id="searchForm">
            <div class="search-box position-relative">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" id="searchInput" placeholder="Search departments..." value="{{ request('search') }}" style="padding-right: 30px;">
                @if(request('search'))
                    <button type="button" class="btn-clear-search" onclick="window.location.href='{{ route('admin.departments.index') }}'" title="Clear Search">
                        <i class="fas fa-times"></i>
                    </button>
                @endif
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem;"><i class="fas fa-search"></i> Search</button>
        </form>
    </div>
    <div class="card-body">
        <div class="table-wrap table-responsive">
            <table class="premium-table w-100">
                <thead>
                    <tr>
                        <th style="width: 16.6%;">Department Name</th>
                        <th class="text-center" style="width: 33.4%;">Short Code</th>
                        <th class="text-center" style="width: 33.4%;">Total Faculty</th>
                        <th class="text-end" style="width: 16.6%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $dept)
                    <tr>
                        <td>
                            <div class="user-cell">
                                @php
                                    $deptName = trim($dept->name ?? 'Unknown');
                                    $words = preg_split("/\s+/", $deptName);
                                    $initials = count($words) > 1 
                                        ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
                                        : strtoupper(substr($deptName, 0, 2));
                                    $colors = ['emerald', 'cyan', 'rose', 'blue', 'amber', 'purple', 'indigo'];
                                    $colorClass = $colors[strlen($deptName) % count($colors)];
                                @endphp
                                <div class="avatar-sm {{ $colorClass }}">{{ $initials }}</div>
                                <div>
                                    <div class="user-name">{{ $dept->name }}</div>
                                    <div class="user-sub">{{ $dept->faculty ?? 'No Faculty' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge dark">{{ $dept->code ?? 'N/A' }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge neutral"><i class="fas fa-users"></i> {{ $dept->teachers_count }} Faculty</span>
                        </td>
                        <td class="text-end">
                            <div class="action-group justify-content-end">
                                <button class="action-btn edit edit-btn" data-bs-toggle="modal" data-bs-target="#editDeptModal"
                                    data-id="{{ $dept->id }}"
                                    data-name="{{ $dept->name }}"
                                    data-code="{{ $dept->code }}"
                                    data-faculty="{{ $dept->faculty }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="{{ route('admin.departments.destroy', $dept->id) }}" method="POST" class="m-0 p-0 delete-form d-flex align-items-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="action-btn delete delete-btn"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-building-columns fa-3x text-muted mb-3" style="opacity: 0.2;"></i>
                                <h6 class="text-heading fw-bold">No Departments found</h6>
                                <p class="text-muted small">Add your first department to get started.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($departments->hasPages())
            <div class="px-4 py-3 border-top">
                {{ $departments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('modals')
<!-- ADD DEPARTMENT MODAL -->
<div class="modal fade" id="addDeptModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content premium">
            <div class="modal-head gradient">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Add Department</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <form action="{{ route('admin.departments.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Department Name</label>
                        <input type="text" name="name" class="form-input" placeholder="e.g. Computer Science" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Short Code</label>
                        <input type="text" name="code" class="form-input" placeholder="e.g. CSE" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Faculty</label>
                        <input type="text" name="faculty" class="form-input" placeholder="e.g. Faculty of Engineering">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" style="margin-top:4px;">
                        <i class="fas fa-check-circle"></i> Save Department
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT DEPARTMENT MODAL -->
<div class="modal fade" id="editDeptModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content premium">
            <div class="modal-head dark-grad">
                <h5 class="modal-title"><i class="fas fa-pen"></i> Edit Department</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
            </div>
            <div class="modal-body-content">
                <form id="editDeptForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label">Department Name</label>
                        <input type="text" name="name" id="edit_name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Short Code</label>
                        <input type="text" name="code" id="edit_code" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Faculty</label>
                        <input type="text" name="faculty" id="edit_faculty" class="form-input">
                    </div>
                    <div class="form-actions mt-3">
                        <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Update</button>
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
        const editButtons = document.querySelectorAll('.edit-btn');
        const editForm = document.getElementById('editDeptForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                
                document.getElementById('edit_name').value = this.getAttribute('data-name');
                document.getElementById('edit_code').value = this.getAttribute('data-code') || '';
                document.getElementById('edit_faculty').value = this.getAttribute('data-faculty') || '';
                
                let actionUrl = "{{ route('admin.departments.update', ':id') }}";
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
            Toast.fire({ icon: 'success', title: {!! json_encode(session('success')) !!} });
        @endif
        @if(session('error'))
            Toast.fire({ icon: 'error', title: {!! json_encode(session('error')) !!} });
        @endif
        @if($errors->any())
            Toast.fire({ icon: 'error', title: "Validation Error", text: {!! json_encode($errors->first()) !!} });
        @endif
    });
</script>
@endpush
