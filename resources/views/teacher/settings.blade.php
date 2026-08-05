@extends('layouts.teacher')

@section('title', 'Account Settings — TeacherHub OBE')
@section('page_title', 'Account Settings')

@section('content')
<div class="p-hero">
    <div><div class="p-hero-h">Account Settings</div><div class="p-hero-sub">Update your personal details and password</div></div>
    <a href="{{ route('teacher.profile') }}" class="btn-primary" style="background: var(--bg-muted); color: var(--tx-h); box-shadow: none; border: 1px solid var(--bd-lt);"><i class="fas fa-arrow-left"></i> Back to Profile</a>
</div>



<div class="d-card" style="animation-delay:.05s; max-width: 900px; margin: 0 auto 30px;">
    <!-- Cover Background -->
    <div style="height: 120px; background: linear-gradient(135deg, rgba(5,150,105,0.1), rgba(16,185,129,0.15)); position: relative; border-bottom: 1px solid var(--bd-lt); border-top-left-radius: var(--r-lg); border-top-right-radius: var(--r-lg);">
    </div>
    
    <div class="profile-hdr-wrapper">
        @php
            $name = $user->name ?? 'Teacher';
            $words = array_filter(explode(' ', trim($name)));
            $initials = strtoupper(substr(array_shift($words), 0, 1));
            if (!empty($words)) {
                $initials .= strtoupper(substr(array_shift($words), 0, 1));
            }
        @endphp
        <div class="profile-hdr-flex">
            <div class="profile-avatar-circle">
                {{ $initials }}
            </div>
            <div class="profile-name-block">
                <h3 style="margin: 0 0 6px; color: var(--tx-h); font-weight: 800; font-size: 1.5rem; letter-spacing: -0.5px;">Update Account</h3>
                <p style="margin: 0; color: var(--tx-m); font-size: 0.95rem;">Manage your personal information and security preferences.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('teacher.settings.update') }}" method="POST">
        @csrf
        
        <div class="d-card-body" style="padding: 30px;">
            <!-- Personal Information Section -->
            <div style="background: var(--bg-card); border: 1px solid var(--bd-lt); border-radius: var(--r-md); padding: 25px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                <h6 style="color: var(--tx-h); font-weight: 700; margin-bottom: 24px; font-size: 1.05rem; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid var(--bd-lt); padding-bottom: 15px;">
                    <i class="fas fa-user-edit" style="color: var(--primary);"></i> Personal Information
                </h6>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <label style="display: block; font-size: 0.8rem; color: var(--tx-m); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Full Name <span style="color:var(--danger)">*</span></label>
                        <div style="position: relative;">
                            <i class="fas fa-user" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--tx-s);"></i>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required 
                                   style="border-radius: var(--r-sm); border: 1px solid var(--bd-lt); padding: 12px 15px 12px 42px; font-size: 0.95rem; color: var(--tx-h); background: #f8fafc; transition: all 0.2s;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label style="display: block; font-size: 0.8rem; color: var(--tx-m); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Email Address <span style="color:var(--danger)">*</span></label>
                        <div style="position: relative;">
                            <i class="fas fa-envelope" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--tx-s);"></i>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required 
                                   style="border-radius: var(--r-sm); border: 1px solid var(--bd-lt); padding: 12px 15px 12px 42px; font-size: 0.95rem; color: var(--tx-h); background: #f8fafc; transition: all 0.2s;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label style="display: block; font-size: 0.8rem; color: var(--tx-m); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Contact Number</label>
                        <div style="position: relative;">
                            <i class="fas fa-phone-alt" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--tx-s);"></i>
                            <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $user->contact_number) }}" placeholder="e.g. +880 1XXX-XXXXXX"
                                   style="border-radius: var(--r-sm); border: 1px solid var(--bd-lt); padding: 12px 15px 12px 42px; font-size: 0.95rem; color: var(--tx-h); background: #f8fafc; transition: all 0.2s;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label style="display: block; font-size: 0.8rem; color: var(--tx-m); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Designation</label>
                        <div style="position: relative;">
                            <i class="fas fa-briefcase" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--tx-s);"></i>
                            <input type="text" class="form-control" value="{{ $user->designation }}" disabled 
                                   style="border-radius: var(--r-sm); border: 1px dashed var(--bd); padding: 12px 15px 12px 42px; font-size: 0.95rem; color: var(--tx-m); background: #f1f5f9; cursor: not-allowed;">
                        </div>
                        <small style="color: var(--tx-s); font-size: 0.75rem; margin-top: 6px; display: block;"><i class="fas fa-info-circle"></i> Designation can only be updated by Admin.</small>
                    </div>
                </div>
            </div>

            <!-- Security Section -->
            <div style="background: var(--bg-card); border: 1px solid var(--bd-lt); border-radius: var(--r-md); padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                <h6 style="color: var(--tx-h); font-weight: 700; margin-bottom: 24px; font-size: 1.05rem; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid var(--bd-lt); padding-bottom: 15px;">
                    <i class="fas fa-shield-alt" style="color: var(--primary);"></i> Security & Password
                </h6>
                
                <div class="row g-4">
                    <div class="col-md-12">
                        <label style="display: block; font-size: 0.8rem; color: var(--tx-m); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Current Password</label>
                        <div style="position: relative;">
                            <i class="fas fa-lock" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--tx-s);"></i>
                            <input type="password" name="current_password" class="form-control" placeholder="Enter current password to make changes" 
                                   style="border-radius: var(--r-sm); border: 1px solid var(--bd-lt); padding: 12px 15px 12px 42px; font-size: 0.95rem; color: var(--tx-h); background: #f8fafc; transition: all 0.2s;">
                        </div>
                        <small style="color: var(--tx-s); font-size: 0.75rem; margin-top: 6px; display: block;"><i class="fas fa-info-circle"></i> Leave blank if you don't want to change your password.</small>
                    </div>
                    <div class="col-md-6">
                        <label style="display: block; font-size: 0.8rem; color: var(--tx-m); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">New Password</label>
                        <div style="position: relative;">
                            <i class="fas fa-key" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--tx-s);"></i>
                            <input type="password" name="password" class="form-control" placeholder="Enter new password" 
                                   style="border-radius: var(--r-sm); border: 1px solid var(--bd-lt); padding: 12px 15px 12px 42px; font-size: 0.95rem; color: var(--tx-h); background: #f8fafc; transition: all 0.2s;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label style="display: block; font-size: 0.8rem; color: var(--tx-m); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Confirm New Password</label>
                        <div style="position: relative;">
                            <i class="fas fa-check-double" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--tx-s);"></i>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Re-type new password" 
                                   style="border-radius: var(--r-sm); border: 1px solid var(--bd-lt); padding: 12px 15px 12px 42px; font-size: 0.95rem; color: var(--tx-h); background: #f8fafc; transition: all 0.2s;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="settings-footer">
            <a href="{{ route('teacher.profile') }}" class="btn settings-btn-cancel"><i class="fas fa-times" style="margin-right: 6px;"></i> Cancel</a>
            <button type="submit" class="btn-primary settings-btn-save"><i class="fas fa-save" style="margin-right: 8px;"></i> Save Changes</button>
        </div>
    </form>
</div>

<style>
    /* Add focus styling for inputs to match premium theme */
    .form-control:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15) !important;
        outline: none !important;
    }
    
    .settings-footer {
        padding: 24px 30px;
        background: rgba(248,250,252,0.8);
        border-top: 1px solid var(--bd-lt);
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        border-bottom-left-radius: var(--r-lg);
        border-bottom-right-radius: var(--r-lg);
    }
    .settings-btn-cancel {
        padding: 12px 24px;
        border-radius: var(--r-sm);
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--tx-m);
        background: #fff;
        border: 1px solid var(--bd-lt);
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        transition: all 0.2s;
    }
    .settings-btn-save {
        padding: 12px 30px;
        border-radius: var(--r-sm);
        font-size: 0.9rem;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(16,185,129,0.25);
    }
    
    /* Profile specific responsive styles */
    .profile-hdr-wrapper {
        padding: 0 30px 25px;
        border-bottom: 1px solid var(--bd-lt);
        background: transparent;
        position: relative;
        z-index: 10;
    }
    .profile-hdr-flex {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 20px;
    }
    .profile-avatar-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #059669, #10b981);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 2.5rem;
        font-weight: 800;
        border: 4px solid #fff;
        box-shadow: 0 4px 15px rgba(5,150,105,0.25);
        flex-shrink: 0;
        margin-top: -60px;
    }
    .profile-name-block {
        padding-top: 10px;
    }
    
    @media (max-width: 576px) {
        .profile-hdr-wrapper {
            padding: 0 15px 20px;
        }
        .profile-hdr-flex {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }
        .profile-name-block {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .profile-name-block > div {
            justify-content: center !important;
        }
        .hide-mobile {
            display: none !important;
        }
        .settings-footer {
            flex-direction: column-reverse;
            padding: 20px 15px;
            gap: 12px;
        }
        .settings-btn-cancel, .settings-btn-save {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endsection
