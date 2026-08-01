@extends('layouts.admin')
@section('title', 'Account Settings')

@section('content')
<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold" style="color: var(--text-heading);">Account Settings</h3>
            <p class="text-muted">Manage your profile details and password.</p>
        </div>
    </div>



    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card shadow-sm border-0 mb-4" style="border-radius: var(--radius-lg);">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.account-settings.update') }}" method="POST">
                        @csrf
                        
                        <h5 class="fw-bold mb-4" style="color: var(--primary);"><i class="fas fa-user me-2"></i> Personal Information</h5>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-5">

                        <h5 class="fw-bold mb-4" style="color: var(--primary);"><i class="fas fa-lock me-2"></i> Security (Optional)</h5>
                        <p class="text-muted small mb-4">Leave these fields blank if you do not wish to change your password.</p>

                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Current Password</label>
                                <div class="form-control d-flex align-items-center p-0 @error('current_password') is-invalid @enderror" style="overflow: hidden; background-color: var(--bg-card);">
                                    <input type="password" name="current_password" id="current_password" class="border-0 bg-transparent flex-grow-1 m-0" placeholder="Current password" style="outline: none; padding: 10px 15px; min-width: 0; box-shadow: none;">
                                    <button class="btn border-0 text-muted m-0 d-flex align-items-center justify-content-center" type="button" onclick="togglePassword('current_password', this)" style="background: transparent; box-shadow: none; padding: 0 15px; height: 100%; min-width: 45px;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('current_password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6 d-none d-md-block"></div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">New Password</label>
                                <div class="form-control d-flex align-items-center p-0 @error('password') is-invalid @enderror" style="overflow: hidden; background-color: var(--bg-card);">
                                    <input type="password" name="password" id="new_password" class="border-0 bg-transparent flex-grow-1 m-0" placeholder="Min 8 chars" style="outline: none; padding: 10px 15px; min-width: 0; box-shadow: none;">
                                    <button class="btn border-0 text-muted m-0 d-flex align-items-center justify-content-center" type="button" onclick="togglePassword('new_password', this)" style="background: transparent; box-shadow: none; padding: 0 15px; height: 100%; min-width: 45px;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Confirm New Password</label>
                                <div class="form-control d-flex align-items-center p-0" style="overflow: hidden; background-color: var(--bg-card);">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="border-0 bg-transparent flex-grow-1 m-0" placeholder="Confirm password" style="outline: none; padding: 10px 15px; min-width: 0; box-shadow: none;">
                                    <button class="btn border-0 text-muted m-0 d-flex align-items-center justify-content-center" type="button" onclick="togglePassword('password_confirmation', this)" style="background: transparent; box-shadow: none; padding: 0 15px; height: 100%; min-width: 45px;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-5">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-light" style="border-radius: var(--radius-md);">Cancel</a>
                            <button type="submit" class="btn btn-primary" style="border-radius: var(--radius-md);">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sidebar Info Card -->
        <div class="col-12 col-xl-4">
            <div class="card shadow-sm border-0" style="border-radius: var(--radius-lg); background: linear-gradient(135deg, var(--primary), #8b5cf6); color: white;">
                <div class="card-body p-4 text-center">
                    <div class="avatar-lg mx-auto mb-3" style="width: 80px; height: 80px; font-size: 32px; background: rgba(255,255,255,0.2); box-shadow: none;">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="mb-3 opacity-75">{{ ucfirst($user->role ?? 'Administrator') }}</p>
                    <hr class="border-light opacity-25 my-3">
                    <p class="small mb-0 opacity-75">Member since {{ $user->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId, btn) {
        const field = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection
