@extends('layouts.admin')
@section('title', 'Dashboard - Admin Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<!-- Welcome Banner -->
            <div class="welcome-banner">
                <div class="welcome-content">
                    <div class="welcome-greeting">
                        @php
                            $hour = now()->format('H');
                            if ($hour < 12) {
                                $greeting = 'Good morning';
                                $icon = 'fas fa-sun';
                            } elseif ($hour < 17) {
                                $greeting = 'Good afternoon';
                                $icon = 'fas fa-cloud-sun';
                            } else {
                                $greeting = 'Good evening';
                                $icon = 'fas fa-moon';
                            }
                        @endphp
                        <i class="{{ $icon }}"></i> {{ $greeting }},
                    </div>
                    <h2 class="welcome-title">Welcome back, {{ Auth::user()->name ?? 'Admin' }}!</h2>
                    <p class="welcome-desc">Here's what's happening across your university management system today.</p>
                    <div class="welcome-date">
                        <i class="far fa-calendar-alt"></i>
                        <span id="currentDate">{{ \Carbon\Carbon::now()->format('l, jS F Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon-wrap blue"><i class="fas fa-user-graduate"></i></div>
                    <div class="stat-info">
                        <div class="stat-label">Total Students</div>
                        <div class="stat-number">{{ $stats['students'] }}</div>
                        <div class="stat-trend {{ $trends['students'] >= 0 ? 'up' : 'down' }}"><i class="fas fa-arrow-{{ $trends['students'] >= 0 ? 'up' : 'down' }}"></i> {{ abs($trends['students']) }}% from last month</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap purple"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="stat-info">
                        <div class="stat-label">Faculty Members</div>
                        <div class="stat-number">{{ $stats['teachers'] }}</div>
                        <div class="stat-trend {{ $trends['teachers'] >= 0 ? 'up' : 'down' }}"><i class="fas fa-arrow-{{ $trends['teachers'] >= 0 ? 'up' : 'down' }}"></i> {{ abs($trends['teachers']) }}% from last month</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap emerald"><i class="fas fa-book-open"></i></div>
                    <div class="stat-info">
                        <div class="stat-label">Active Courses</div>
                        <div class="stat-number">{{ $stats['courses'] }}</div>
                        <div class="stat-trend {{ $trends['courses'] >= 0 ? 'up' : 'down' }}"><i class="fas fa-arrow-{{ $trends['courses'] >= 0 ? 'up' : 'down' }}"></i> {{ abs($trends['courses']) }}% from last month</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap amber"><i class="fas fa-folder-open"></i></div>
                    <div class="stat-info">
                        <div class="stat-label">Course Files</div>
                        <div class="stat-number">{{ $stats['files'] }}</div>
                        <div class="stat-trend {{ $trends['files'] >= 0 ? 'up' : 'down' }}"><i class="fas fa-arrow-{{ $trends['files'] >= 0 ? 'up' : 'down' }}"></i> {{ abs($trends['files']) }}% from last month</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="{{ route('admin.student-info.index') }}" class="quick-action-card">
                    <div class="qa-icon" style="background: #eff6ff; color: #3b82f6;"><i class="fas fa-user-plus"></i></div>
                    <div class="qa-text">
                        <div class="qa-title">Add Student</div>
                        <div class="qa-desc">Register & enroll</div>
                    </div>
                </a>
                <a href="{{ route('admin.teacher-info.index') }}" class="quick-action-card">
                    <div class="qa-icon" style="background: #f5f3ff; color: #8b5cf6;"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="qa-text">
                        <div class="qa-title">Add Teacher</div>
                        <div class="qa-desc">Assign courses</div>
                    </div>
                </a>
                <a href="{{ route('admin.courses.index') }}" class="quick-action-card">
                    <div class="qa-icon" style="background: #ecfdf5; color: #10b981;"><i class="fas fa-book-open"></i></div>
                    <div class="qa-text">
                        <div class="qa-title">New Course</div>
                        <div class="qa-desc">Add to registry</div>
                    </div>
                </a>
                <a href="{{ route('admin.course-materials.index') }}" class="quick-action-card">
                    <div class="qa-icon" style="background: #fffbeb; color: #f59e0b;"><i class="fas fa-cloud-upload-alt"></i></div>
                    <div class="qa-text">
                        <div class="qa-title">Upload File</div>
                        <div class="qa-desc">Course materials</div>
                    </div>
                </a>
            </div>

            <!-- Two Column: Table + Activity -->
            <div class="grid-2col">
                <!-- Management Log -->
                <div class="data-card">
                    <div class="card-header">
                        <div>
                            <h5 class="card-title"><i class="fas fa-clipboard-list"></i> Recent Records</h5>
                            <p class="card-subtitle">Latest entries across the system</p>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="search-box">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" placeholder="Search records...">
                            </div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">Add New</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrap">
                            <table class="premium-table">
                                <thead>
                                    <tr>
                                        <th>Identity</th>
                                        <th>Role</th>
                                        <th>Assignment</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentRecords as $record)
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <div class="avatar-sm {{ $record->role == 'admin' ? 'rose' : ($record->role == 'teacher' ? 'emerald' : 'blue') }}">
                                                    {{ strtoupper(substr($record->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <div class="user-name">{{ $record->name }}</div>
                                                    <div class="user-sub">{{ $record->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($record->role == 'admin')
                                                <span class="badge dark"><i class="fas fa-shield-halved"></i> Admin</span>
                                            @elseif($record->role == 'teacher')
                                                <span class="badge success"><i class="fas fa-chalkboard-teacher"></i> Teacher</span>
                                            @else
                                                <span class="badge primary"><i class="fas fa-user-graduate"></i> Student</span>
                                            @endif
                                        </td>
                                        <td><span class="badge neutral">{{ $record->student_id ?? 'N/A' }}</span></td>
                                        <td>
                                            <div class="action-group">
                                                <button class="action-btn edit" data-bs-toggle="modal" data-bs-target="#editModal" 
                                                    data-id="{{ $record->id }}" 
                                                    data-name="{{ $record->name }}" 
                                                    data-role="{{ $record->role }}" 
                                                    data-reference="{{ str_contains($record->email, '@') ? $record->email : $record->student_id }}">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <form action="{{ route('admin.dashboard.delete', $record->id) }}" method="POST" class="m-0 p-0 delete-form" style="display: flex; align-items: center;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="action-btn delete delete-btn"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No recent records found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="data-card">
                    <div class="card-header">
                        <div>
                            <h5 class="card-title"><i class="fas fa-clock-rotate-left"></i> Recent Activity</h5>
                            <p class="card-subtitle">System updates & actions</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="activity-list">
                            @forelse($recentActivities as $activity)
                            <div class="activity-item">
                                <div class="activity-dot {{ ['green', 'blue', 'purple', 'amber', 'red'][rand(0, 4)] }}"></div>
                                <div class="activity-text">{!! $activity->description !!}</div>
                                <div class="activity-time">{{ $activity->created_at->diffForHumans() }}</div>
                            </div>
                            @empty
                            <div class="activity-item">
                                <div class="activity-text">No recent activities.</div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
@endsection

@push('modals')
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content premium">
                <div class="modal-head dark-grad">
                    <h5 class="modal-title"><i class="fas fa-pen"></i> Edit Record</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
                </div>
                <div class="modal-body-content">
                    <form id="editRecordForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-input" name="name" id="edit_name" required>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Role Type</label>
                                <select class="form-select" name="role" id="edit_role" required>
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">ID / Reference</label>
                                <input type="text" class="form-input" name="reference" id="edit_reference" required>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== ADD MODAL ====== -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content premium">
                <div class="modal-head gradient">
                    <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Create New Record</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button>
                </div>
                <div class="modal-body-content">
                    <form method="POST" action="{{ route('admin.dashboard.store') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Classification</label>
                            <select class="form-select" name="classification" required>
                                <option value="Student">Student</option>
                                <option value="Teacher">Teacher</option>
                                <option value="Admin">Admin</option>
                                <option value="Course">Course</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Full Name / Title</label>
                            <input type="text" class="form-input" name="name" placeholder="Enter name..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">ID / Email / Course Code</label>
                            <input type="text" class="form-input" name="id_email" placeholder="Enter ID or Email..." required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" style="margin-top: 4px;">
                            <i class="fas fa-check-circle"></i> Confirm and Add
                        </button>
                    </form>
                </div>
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
        const editForm = document.getElementById('editRecordForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const role = this.getAttribute('data-role');
                const reference = this.getAttribute('data-reference');
                
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_role').value = role;
                document.getElementById('edit_reference').value = reference;
                
                // Set the form action URL dynamically
                let actionUrl = "{{ route('admin.dashboard.update', ':id') }}";
                editForm.action = actionUrl.replace(':id', id);
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
                    text: "You won't be able to revert this record!",
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

        // --- SweetAlert2 Toast Notifications ---
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            background: 'var(--bg-card)',
            color: 'var(--text-heading)',
            customClass: { popup: 'premium-toast' },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
        @endif

        @if(session('error'))
            Toast.fire({ icon: 'error', title: "{{ session('error') }}" });
        @endif

        @if($errors->any())
            Toast.fire({
                icon: 'error',
                title: "Validation Error",
                text: "{{ $errors->first() }}"
            });
        @endif
    });
</script>
@endpush
