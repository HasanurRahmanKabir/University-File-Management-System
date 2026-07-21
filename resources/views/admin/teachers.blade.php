@extends('layouts.admin')
@section('title', 'Teachers - Admin Dashboard')
@section('page-title', 'Teacher Management')
@section('breadcrumb', 'Teacher Management')

@section('content')

@endsection

@push('modals')
<div class="modal fade" id="addDeptModal" tabindex="-1"><div class="modal-dialog modal-sm modal-dialog-centered"><div class="modal-content premium"><div class="modal-head dark-grad"><h5 class="modal-title"><i class="fas fa-building"></i> Add Department</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form><div class="form-group"><label class="form-label">Department Name</label><input type="text" class="form-input" placeholder="e.g. Pharmacy, Civil"></div><button type="submit" class="btn btn-primary btn-block"><i class="fas fa-check"></i> Save</button></form></div></div></div></div>

    <!-- ADD TEACHER -->
    <div class="modal fade" id="addTeacherModal" tabindex="-1"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content premium"><div class="modal-head gradient"><h5 class="modal-title"><i class="fas fa-user-plus"></i> Register Teacher</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form>
        <div class="form-grid"><div class="form-group"><label class="form-label">Full Name</label><input type="text" class="form-input" placeholder="Enter full name" required></div><div class="form-group"><label class="form-label">Email Address</label><input type="email" class="form-input" placeholder="example@univ.edu" required></div></div>
        <div class="form-grid"><div class="form-group"><label class="form-label">Department</label><select class="form-select"><option selected disabled>Select Department</option><option>CSE</option><option>EEE</option><option>BBA</option></select></div><div class="form-group"><label class="form-label">Set Password</label><input type="password" class="form-input" placeholder="Create password" required></div></div>
        <div class="form-divider"><i class="fas fa-book-open"></i> Offer Courses</div>
        <div class="check-grid"><div class="check-item"><input type="checkbox" id="tc1"><label for="tc1">CSE-101</label></div><div class="check-item"><input type="checkbox" id="tc2"><label for="tc2">CSE-401</label></div><div class="check-item"><input type="checkbox" id="tc3"><label for="tc3">EEE-302</label></div></div>
        <div style="text-align:center;margin-top:20px;"><button type="submit" class="btn btn-primary" style="padding:10px 48px;"><i class="fas fa-check-circle"></i> Register</button></div>
    </form></div></div></div></div>

    <!-- EDIT TEACHER -->
    <div class="modal fade" id="editTeacherModal" tabindex="-1"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content premium"><div class="modal-head dark-grad"><h5 class="modal-title"><i class="fas fa-pen"></i> Edit Teacher</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form>
        <div class="form-grid"><div class="form-group"><label class="form-label">Full Name</label><input type="text" class="form-input" value="Masud Tarek"></div><div class="form-group"><label class="form-label">Email</label><input type="email" class="form-input" value="masud.tarek@university.edu"></div></div>
        <div class="form-grid"><div class="form-group"><label class="form-label">Department</label><select class="form-select"><option selected>CSE</option><option>EEE</option></select></div><div class="form-group"><label class="form-label">New Password</label><input type="password" class="form-input" placeholder="Leave blank if no change"></div></div>
        <div class="form-actions"><button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Update</button></div>
    </form></div></div></div></div>
@endpush
