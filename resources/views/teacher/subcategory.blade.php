@extends('layouts.teacher')

@section('title', 'Subcategory List - Teacher Dashboard')

@section('content')

        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Subcategory (Course) List</h2>
                <form action="#" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-light border delete-btn">
        <i class="fas fa-trash text-danger"></i>
    </button>
</form>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4">02</td>
                                    <td><span class="fw-bold">Sorting Algorithms</span></td>
                                    <td><span class="badge bg-light text-dark border">Algorithm</span></td>
                                    <td>CSE-202</td>
                                    <td>
                                        <form action="#" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-light border delete-btn">
        <i class="fas fa-trash text-danger"></i>
    </button>
</form>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4">03</td>
                                    <td><span class="fw-bold">Tree & Graph</span></td>
                                    <td><span class="badge bg-light text-dark border">Data Structure</span></td>
                                    <td>CSE-201</td>
                                    <td>
                                        <form action="#" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-light border delete-btn">
        <i class="fas fa-trash text-danger"></i>
    </button>
</form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <div class="modal fade" id="addSubCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Add New Subcategory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Select Parent Category</label>
                            <select class="form-select">
                                <option selected disabled>Choose Category</option>
                                <option>Data Structure</option>
                                <option>Algorithm</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Subcategory Name</label>
                            <input type="text" class="form-control" placeholder="e.g. Stack & Queue">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Course Code</label>
                            <input type="text" class="form-control" placeholder="e.g. CSE-201">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Subcategory</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editSubCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold">Edit Subcategory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Parent Category</label>
                            <select class="form-select">
                                <option selected>Data Structure</option>
                                <option>Algorithm</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Subcategory Name</label>
                            <input type="text" class="form-control" value="Array & Linked List">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Course Code</label>
                            <input type="text" class="form-control" value="CSE-201">
                        </div>
                        <div class="d-flex gap-2 mt-4">
                            <button type="button" class="btn btn-secondary w-50" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success w-50">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection
