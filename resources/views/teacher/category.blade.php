@extends('layouts.teacher')

@section('title', 'Category List - Teacher Dashboard')

@section('content')

        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Course Categories</h2>
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
                                            <td><span class="fw-bold">Algorithm</span></td>
                                            <td><span class="badge bg-info text-dark">04 Subcategories</span></td>
                                            <td>Design and Analysis of Computational Algorithms.</td>
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
            </div>
        </div>
    <div class="modal fade" id="addCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold">Category Name</label>
                            <input type="text" class="form-control" placeholder="e.g. Database Systems">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold">Short Description</label>
                            <textarea class="form-control" rows="3" placeholder="Brief about this category..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">Create Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Category Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold">Category Name</label>
                            <input type="text" class="form-control" value="Data Structure">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold">Update Description</label>
                            <textarea class="form-control" rows="3">Linear and Non-linear data organization.</textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary w-50" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success w-50">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection
