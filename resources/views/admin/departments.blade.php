@extends('layouts.admin')
@section('title', 'Departments - Admin Dashboard')
@section('page-title', 'Departments')
@section('breadcrumb', 'Departments')

@section('content')

@endsection

@push('modals')
<div class="modal fade" id="addDeptModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content premium"><div class="modal-head gradient"><h5 class="modal-title"><i class="fas fa-plus-circle"></i> Add Department</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form>
        <div class="form-group"><label class="form-label">Department Name</label><input type="text" class="form-input" placeholder="e.g. Computer Science" required></div>
        <div class="form-group"><label class="form-label">Short Code</label><input type="text" class="form-input" placeholder="e.g. CSE" required></div>
        <div class="form-group"><label class="form-label">Faculty</label><input type="text" class="form-input" placeholder="e.g. Faculty of Engineering"></div>
        <button type="submit" class="btn btn-primary btn-block" style="margin-top:4px;"><i class="fas fa-check-circle"></i> Save Department</button>
    </form></div></div></div></div>

    <!-- EDIT -->
    <div class="modal fade" id="editDeptModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content premium"><div class="modal-head dark-grad"><h5 class="modal-title"><i class="fas fa-pen"></i> Edit Department</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form>
        <div class="form-group"><label class="form-label">Department Name</label><input type="text" class="form-input" value="Computer Science & Engineering"></div>
        <div class="form-group"><label class="form-label">Short Code</label><input type="text" class="form-input" value="CSE"></div>
        <div class="form-actions"><button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Update</button></div>
    </form></div></div></div></div>
@endpush
