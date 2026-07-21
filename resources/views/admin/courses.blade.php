@extends('layouts.admin')
@section('title', 'Courses - Admin Dashboard')
@section('page-title', 'Course Information')
@section('breadcrumb', 'Course Information')

@section('content')

@endsection

@push('modals')
<div class="modal fade" id="addCourseModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content premium"><div class="modal-head gradient"><h5 class="modal-title"><i class="fas fa-plus-circle"></i> Register Course</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form>
        <div class="form-group"><label class="form-label">Course Code</label><input type="text" class="form-input" placeholder="e.g. CSE-201" required></div>
        <div class="form-group"><label class="form-label">Course Title</label><input type="text" class="form-input" placeholder="e.g. Object Oriented Programming" required></div>
        <div class="form-group"><label class="form-label">Department</label><select class="form-select" required><option selected disabled>Choose Department</option><option>CSE</option><option>EEE</option><option>BBA</option><option>Pharmacy</option></select></div>
        <button type="submit" class="btn btn-primary btn-block" style="margin-top:4px;"><i class="fas fa-check-circle"></i> Add Course</button>
    </form></div></div></div></div>

    <!-- EDIT COURSE -->
    <div class="modal fade" id="editCourseModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content premium"><div class="modal-head dark-grad"><h5 class="modal-title"><i class="fas fa-pen"></i> Edit Course</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form>
        <div class="form-group"><label class="form-label">Course Code</label><input type="text" class="form-input" value="CSE-201"></div>
        <div class="form-group"><label class="form-label">Course Title</label><input type="text" class="form-input" value="Object Oriented Programming"></div>
        <div class="form-group"><label class="form-label">Department</label><select class="form-select"><option selected>CSE</option><option>EEE</option><option>BBA</option></select></div>
        <div class="form-actions"><button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Update</button></div>
    </form></div></div></div></div>
@endpush
