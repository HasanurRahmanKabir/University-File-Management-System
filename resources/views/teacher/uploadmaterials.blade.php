@extends('layouts.teacher')

@section('title', 'Upload Materials — TeacherHub OBE')
@section('page_title', 'Upload Materials')

@section('content')
<div class="row g-4">

    <!-- Upload Form -->
    <div class="col-xl-5 col-lg-5 col-12">
        <div class="d-card" style="animation-delay:.05s">
            <div class="d-card-header">
                <div class="d-card-title"><div class="d-card-ico"><i class="fas fa-cloud-arrow-up"></i></div>Add New File</div>
            </div>
            <div class="d-card-body">
                <form>
                    <div class="fg">
                        <label class="flabel">Select Course</label>
                        <select class="finput" style="cursor:pointer;">
                            <option selected disabled>— Choose Course Code —</option>
                            <option>CSE-0400 — System Design Project</option>
                            <option>CSE-0302 — Database Systems Lab</option>
                        </select>
                    </div>
                    <div class="fg">
                        <label class="flabel">Material Title</label>
                        <input type="text" class="finput" placeholder="e.g. Lecture 01 — Introduction">
                    </div>
                    <div class="fg">
                        <label class="flabel">File Privacy</label>
                        <div class="priv-seg">
                            <input type="radio" name="priv" id="pub" checked>
                            <label for="pub"><i class="fas fa-globe" style="font-size:.72rem;"></i> Public</label>
                            <input type="radio" name="priv" id="me">
                            <label for="me"><i class="fas fa-lock" style="font-size:.70rem;"></i> Only Me</label>
                        </div>
                    </div>
                    <div class="fg">
                        <label class="flabel">Upload File</label>
                        <div class="upload-z" id="dropZone" onclick="document.getElementById('fileIn').click()">
                            <div class="upload-z-ico"><i class="fas fa-file-arrow-up"></i></div>
                            <div class="upload-z-txt">Click or drag &amp; drop your file here</div>
                            <div class="upload-z-hint">PDF · DOCX · PPTX — Max 20 MB</div>
                            <input type="file" hidden id="fileIn">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary" style="width:100%;justify-content:center;padding:11px;">
                        <i class="fas fa-upload"></i> Upload Now
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- File List -->
    <div class="col-xl-7 col-lg-7 col-12">
        <div class="d-card" style="animation-delay:.12s">
            <div class="d-card-header">
                <div class="d-card-title"><div class="d-card-ico"><i class="fas fa-folder-open"></i></div>Manage Uploaded Materials</div>
                <span class="badge b-green" style="padding:5px 12px;">3 files</span>
            </div>
            <div class="d-card-body p0">
                <div class="t-wrap">
                    <table class="t-tbl">
                        <thead><tr><th>File Info</th><th>Course</th><th>Privacy</th><th>Action</th></tr></thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <div class="cat-ico" style="width:34px;height:34px;background:var(--danger-lt);color:var(--danger);">
                                            <i class="fas fa-file-pdf" style="font-size:.85rem;"></i>
                                        </div>
                                        <div><div class="t-name" style="font-size:.82rem;">Lecture_01_Basics.pdf</div><div class="t-sub">Slides · 2.4 MB</div></div>
                                    </div>
                                </td>
                                <td><span class="badge b-blue">CSE-0400</span></td>
                                <td><span class="badge b-green"><i class="fas fa-globe"></i> Public</span></td>
                                <td><div style="display:flex;gap:5px;">
                                    <button class="btn-ico bi-ed" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fas fa-pen"></i></button>
                                    <button class="btn-ico bi-del"><i class="fas fa-trash-alt"></i></button>
                                </div></td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <div class="cat-ico" style="width:34px;height:34px;background:var(--info-lt);color:var(--info);">
                                            <i class="fas fa-file-word" style="font-size:.85rem;"></i>
                                        </div>
                                        <div><div class="t-name" style="font-size:.82rem;">Lab_Assignment_02.docx</div><div class="t-sub">Document · 1.1 MB</div></div>
                                    </div>
                                </td>
                                <td><span class="badge b-blue">CSE-0302</span></td>
                                <td><span class="badge b-gray"><i class="fas fa-lock"></i> Only Me</span></td>
                                <td><div style="display:flex;gap:5px;">
                                    <button class="btn-ico bi-ed" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fas fa-pen"></i></button>
                                    <button class="btn-ico bi-del"><i class="fas fa-trash-alt"></i></button>
                                </div></td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <div class="cat-ico" style="width:34px;height:34px;background:var(--warning-lt);color:var(--warning);">
                                            <i class="fas fa-file-powerpoint" style="font-size:.85rem;"></i>
                                        </div>
                                        <div><div class="t-name" style="font-size:.82rem;">Midterm_Slides.pptx</div><div class="t-sub">Presentation · 5.8 MB</div></div>
                                    </div>
                                </td>
                                <td><span class="badge b-blue">CSE-0400</span></td>
                                <td><span class="badge b-green"><i class="fas fa-globe"></i> Public</span></td>
                                <td><div style="display:flex;gap:5px;">
                                    <button class="btn-ico bi-ed" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fas fa-pen"></i></button>
                                    <button class="btn-ico bi-del"><i class="fas fa-trash-alt"></i></button>
                                </div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><div class="m-ico"><i class="fas fa-pen"></i></div>Edit Material Info</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="fg"><label class="flabel">Material Title</label><input type="text" class="finput" value="Lecture_01_Basics.pdf"></div>
                <div class="fg"><label class="flabel">Course Code</label><select class="finput" style="cursor:pointer;"><option>CSE-0400</option><option>CSE-0302</option></select></div>
                <div class="fg" style="margin-bottom:0;"><label class="flabel">Privacy</label><select class="finput" style="cursor:pointer;"><option>Public</option><option>Only Me</option></select></div>
            </div>
            <div class="modal-footer"><button class="btn-ghost" data-bs-dismiss="modal">Cancel</button><button class="btn-primary"><i class="fas fa-check"></i> Save Changes</button></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const dz=document.getElementById('dropZone');
    if(dz) {
        ['dragover','dragenter'].forEach(e=>dz.addEventListener(e,ev=>{ev.preventDefault();dz.style.borderColor='var(--primary)';dz.style.background='var(--primary-light)';}));
        ['dragleave','drop'].forEach(e=>dz.addEventListener(e,ev=>{ev.preventDefault();dz.style.borderColor='';dz.style.background='';}));
    }
</script>
@endpush
