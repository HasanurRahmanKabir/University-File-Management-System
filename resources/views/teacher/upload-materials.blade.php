@extends('layouts.teacher')

@section('title', 'Upload Materials - Teacher Dashboard')

@section('content')

        <div class="container-fluid">
            <h2 class="mb-4">Upload Course Materials</h2>

            <div class="row">
                <div class="col-lg-5 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-white py-3">
                            <h6 class="mb-0 fw-bold"><i class="fas fa-cloud-upload-alt me-2"></i>Add New File</h6>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Select Course</label>
                                    <select class="form-select">
                                        <option selected disabled>Choose Course Code</option>
                                        <option>CSE-0400 (System Design Project)</option>
                                        <option>CSE-0302 (Database Systems Lab)</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Material Title</label>
                                    <input type="text" class="form-control" placeholder="e.g. Lecture 01 - Intro">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">File Privacy</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="privacy" id="public" checked>
                                            <label class="form-check-label" for="public">Public</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="privacy" id="onlyme">
                                            <label class="form-check-label" for="onlyme">Only Me</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-area mb-3">
                                    <i class="fas fa-file-pdf fa-3x text-muted mb-2"></i>
                                    <p class="small mb-0">Drag and drop file here</p>
                                    <input type="file" hidden id="fileInput">
                                </div>
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
    <div class="modal fade" id="editFileModal" tabindex="-1" aria-labelledby="editFileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFileModalLabel fw-bold">Edit Material Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Material Title</label>
                            <input type="text" class="form-control" value="Lecture_01_Basics.pdf">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Course Code</label>
                            <select class="form-select">
                                <option selected>CSE-0400</option>
                                <option>CSE-0302</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Update Privacy</label>
                            <select class="form-select">
                                <option selected>Public</option>
                                <option>Only Me</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    @endsection
