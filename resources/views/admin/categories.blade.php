@extends('layouts.admin')
@section('title', 'Categories - Admin Dashboard')
@section('page-title', 'Categories')
@section('breadcrumb', 'Categories')

@section('content')

@endsection

@push('modals')
<div class="modal fade" id="addCategoryModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content premium"><div class="modal-head gradient"><h5 class="modal-title"><i class="fas fa-plus-circle"></i> Add Category</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form>
        <div class="form-group"><label class="form-label">Category Name</label><input type="text" class="form-input" placeholder="e.g. Networking" required></div>
        <div class="form-group"><label class="form-label">Core Topic Description</label><input type="text" class="form-input" placeholder="e.g. TCP/IP, Routing" required></div>
        <div class="form-group"><label class="form-label">Status</label><select class="form-select"><option>Active</option><option>Pending</option><option>Inactive</option></select></div>
        <button type="submit" class="btn btn-primary btn-block" style="margin-top:4px;"><i class="fas fa-check-circle"></i> Add Category</button>
    </form></div></div></div></div>

    <!-- EDIT -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content premium"><div class="modal-head dark-grad"><h5 class="modal-title"><i class="fas fa-pen"></i> Edit Category</h5><button type="button" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-xmark"></i></button></div><div class="modal-body-content"><form>
        <div class="form-group"><label class="form-label">Category Name</label><input type="text" class="form-input" value="Operating Systems"></div>
        <div class="form-group"><label class="form-label">Core Topic</label><input type="text" class="form-input" value="Kernel & Memory Management"></div>
        <div class="form-actions"><button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Save</button></div>
    </form></div></div></div></div>
@endpush
