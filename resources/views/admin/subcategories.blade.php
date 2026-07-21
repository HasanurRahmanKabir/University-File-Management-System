@extends('layouts.admin')
@section('title', 'Subcategories - Admin Dashboard')
@section('page-title', 'Subcategories')
@section('breadcrumb', 'Subcategories')

@section('content')

@endsection

@push('modals')
<div class="modal fade" id="addSubCategoryModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content premium"><div class="modal-head gradient"><h5 class="modal-title"><i class="fas fa-plus-circle"></i> Add Subcategory</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form>
        <div class="form-group"><label class="form-label">Department (Main Category)</label><select class="form-select" required><option selected disabled>Select Department</option><option>CSE</option><option>EEE</option><option>BBA</option></select></div>
        <div class="form-group"><label class="form-label">Subcategory Name</label><input type="text" class="form-input" placeholder="e.g. English, Sociology" required></div>
        <button type="submit" class="btn btn-primary btn-block" style="margin-top:4px;"><i class="fas fa-check-circle"></i> Register Subcategory</button>
    </form></div></div></div></div>

    <!-- EDIT -->
    <div class="modal fade" id="editSubCategoryModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content premium"><div class="modal-head dark-grad"><h5 class="modal-title"><i class="fas fa-pen"></i> Edit Subcategory</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form>
        <div class="form-group"><label class="form-label">Department</label><select class="form-select"><option selected>CSE</option><option>EEE</option></select></div>
        <div class="form-group"><label class="form-label">Subcategory Name</label><input type="text" class="form-input" value="Economics"></div>
        <div class="form-actions"><button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Save</button></div>
    </form></div></div></div></div>
@endpush
