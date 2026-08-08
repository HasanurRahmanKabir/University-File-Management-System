@extends('layouts.student')

@section('title', 'My Profile — StudentHub OBE')
@section('page-title', 'My Profile')
@section('breadcrumb', 'My Profile')

@section('content')
<div class="p-hero">
    <div><div class="p-hero-h">My Profile</div><div class="p-hero-sub">View your account details and information</div></div>
</div>

<div class="d-card" style="animation-delay:.05s; max-width: 900px; margin: 0 auto 30px;">
    <!-- Cover Background -->
    <div style="height: 120px; background: linear-gradient(135deg, rgba(37,99,235,0.1), rgba(59,130,246,0.15)); position: relative; border-bottom: 1px solid var(--bd-lt);">
        <div style="position: absolute; right: 20px; top: 20px;">
            <a href="{{ route('student.settings') }}" class="btn-primary" style="padding: 8px 16px; font-size: 0.8rem; box-shadow: var(--sh-sm);"><i class="fas fa-cog"></i> Account Settings</a>
        </div>
    </div>
    
    <div class="profile-hdr-wrapper">
        @php
            $name = $user->name ?? 'Student';
            $words = array_filter(explode(' ', trim($name)));
            $initials = strtoupper(substr(array_shift($words), 0, 1));
            if (!empty($words)) {
                $initials .= strtoupper(substr(array_shift($words), 0, 1));
            }
        @endphp
        <div class="profile-hdr-flex">
            <div class="profile-avatar-circle" style="overflow: hidden;">
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    {{ $initials }}
                @endif
            </div>
            <div class="profile-name-block">
                <h3 style="margin: 0 0 6px; color: var(--tx-h); font-weight: 800; font-size: 1.5rem; letter-spacing: -0.5px;">{{ $user->name }}</h3>
                <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap; justify-content: inherit;">
                    <span style="color: var(--tx-m); font-size: 0.95rem; font-weight: 500;"><i class="fas fa-user-graduate" style="margin-right: 5px; opacity: 0.7;"></i>{{ $user->student_id ?? 'Student' }}</span>
                    <span style="color: var(--bd); font-size: 0.8rem;" class="hide-mobile">|</span>
                    <span class="badge b-blue" style="padding: 4px 10px; font-size: 0.7rem;"><i class="fas fa-check-circle" style="margin-right: 4px;"></i>Active Account</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-card-body" style="padding: 30px;">
        <h6 style="color: var(--tx-h); font-weight: 700; margin-bottom: 24px; font-size: 1.05rem; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-address-card" style="color: var(--primary);"></i> Personal Information
        </h6>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 320px), 1fr)); gap: 20px;">
            <!-- Info Card 1 -->
            <div style="background: var(--bg-muted); border: 1px solid var(--bd-lt); border-radius: var(--r-md); padding: 15px; display: flex; gap: 12px; align-items: center; transition: all 0.2s; overflow: hidden;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: #fff; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.1rem; box-shadow: var(--sh-sm); flex-shrink: 0;">
                    <i class="fas fa-envelope"></i>
                </div>
                <div style="overflow: hidden;">
                    <div style="font-size: 0.7rem; color: var(--tx-m); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 3px;">Email Address</div>
                    <div style="font-size: 0.9rem; color: var(--tx-h); font-weight: 600; word-break: break-word;">{{ $user->email }}</div>
                </div>
            </div>
            <!-- Info Card 2 -->
            <div style="background: var(--bg-muted); border: 1px solid var(--bd-lt); border-radius: var(--r-md); padding: 15px; display: flex; gap: 12px; align-items: center; transition: all 0.2s; overflow: hidden;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: #fff; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.1rem; box-shadow: var(--sh-sm); flex-shrink: 0;">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div style="overflow: hidden;">
                    <div style="font-size: 0.7rem; color: var(--tx-m); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 3px;">Contact Number</div>
                    <div style="font-size: 0.9rem; color: var(--tx-h); font-weight: 600; word-break: break-word;">{{ $user->contact_number ?? 'Not provided' }}</div>
                </div>
            </div>
            <!-- Info Card 3 -->
            <div style="background: var(--bg-muted); border: 1px solid var(--bd-lt); border-radius: var(--r-md); padding: 15px; display: flex; gap: 12px; align-items: center; transition: all 0.2s; overflow: hidden;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: #fff; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.1rem; box-shadow: var(--sh-sm); flex-shrink: 0;">
                    <i class="fas fa-building"></i>
                </div>
                <div style="overflow: hidden;">
                    <div style="font-size: 0.7rem; color: var(--tx-m); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 3px;">Department</div>
                    <div style="font-size: 0.9rem; color: var(--tx-h); font-weight: 600; word-break: break-word;">{{ $user->department ? $user->department->name : 'N/A' }}</div>
                </div>
            </div>
            <!-- Info Card 4 -->
            <div style="background: var(--bg-muted); border: 1px solid var(--bd-lt); border-radius: var(--r-md); padding: 15px; display: flex; gap: 12px; align-items: center; transition: all 0.2s; overflow: hidden;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: #fff; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.1rem; box-shadow: var(--sh-sm); flex-shrink: 0;">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div style="overflow: hidden;">
                    <div style="font-size: 0.7rem; color: var(--tx-m); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 3px;">System Role</div>
                    <div style="font-size: 0.9rem; color: var(--tx-h); font-weight: 600; text-transform: capitalize; word-break: break-word;">{{ $user->role ?? 'Student' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 2.5rem;
        font-weight: 800;
        border: 4px solid #fff;
        box-shadow: 0 4px 15px rgba(37,99,235,0.25);
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
    }
</style>
@endsection
