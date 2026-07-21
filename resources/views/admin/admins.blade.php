@extends('layouts.admin')
@section('title', 'Admins - Admin Dashboard')
@section('page-title', 'Admin Accounts')
@section('breadcrumb', 'Admin Accounts')

@section('content')

@endsection

@push('modals')
<div class="modal fade" id="addAdminModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content premium"><div class="modal-head gradient"><h5 class="modal-title"><i class="fas fa-user-plus"></i> Register Admin</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form>
        <div class="form-group"><label class="form-label">Full Name</label><input type="text" class="form-input" placeholder="Enter admin name" required></div>
        <div class="form-group"><label class="form-label">Email Address</label><input type="email" class="form-input" placeholder="admin@system.com" required></div>
        <div class="form-group"><label class="form-label">Contact Number</label><input type="text" class="form-input" placeholder="+880 1XXX-XXXXXX" required></div>
        <div class="form-group"><label class="form-label">Create Password</label><input type="password" class="form-input" placeholder="Set a secure password" required></div>
        <button type="submit" class="btn btn-primary btn-block" style="margin-top:4px;"><i class="fas fa-check-circle"></i> Complete Registration</button>
    </form></div></div></div></div>

    <!-- EDIT ADMIN -->
    <div class="modal fade" id="editAdminModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content premium"><div class="modal-head dark-grad"><h5 class="modal-title"><i class="fas fa-pen"></i> Update Admin</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form>
        <div class="form-group"><label class="form-label">Full Name</label><input type="text" class="form-input" value="Abdullah Al Mamun"></div>
        <div class="form-group"><label class="form-label">Email</label><input type="email" class="form-input" value="mamun.admin@system.com"></div>
        <div class="form-group"><label class="form-label">Contact</label><input type="text" class="form-input" value="+880 1700-112233"></div>
        <div class="form-group"><label class="form-label">New Password</label><input type="password" class="form-input" placeholder="Leave blank to keep current"></div>
        <div class="form-actions"><button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Save</button></div>
    </form></div></div></div></div>
@endpush
