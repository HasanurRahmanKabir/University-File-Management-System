@extends('layouts.admin')
@section('title', 'My Profile')

@section('content')
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12 col-md-8 mx-auto">
            <div class="card shadow-sm border-0" style="border-radius: var(--radius-lg);">
                <div class="card-body text-center p-3 p-md-5">
                    @php
                        $initials = strtoupper(substr($user->name, 0, 2));
                        $role = ucfirst($user->role ?? 'Administrator');
                    @endphp
                    <div class="avatar-lg mx-auto mb-4" style="width: 100px; height: 100px; font-size: 36px;">
                        {{ $initials }}
                    </div>
                    <h2 class="fw-bold mb-1 text-wrap" style="color: var(--text-heading); word-break: break-word;">{{ $user->name }}</h2>
                    <p class="text-muted mb-4" style="font-size: 1.1rem; word-break: break-all;">{{ $user->email }}</p>
                    
                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill" style="font-size: 0.9rem;">
                        <i class="fas fa-shield-alt me-1"></i> {{ $role }}
                    </span>
                    
                    <div class="mt-5 d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="{{ route('admin.account-settings') }}" class="btn btn-primary px-4 py-2 w-100 w-sm-auto text-wrap" style="border-radius: var(--radius-md);">
                            <i class="fas fa-cog me-2"></i> Edit Account Settings
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-light px-4 py-2 w-100 w-sm-auto text-wrap" style="border-radius: var(--radius-md);">
                            <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
