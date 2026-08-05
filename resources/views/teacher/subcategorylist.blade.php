@extends('layouts.teacher')

@section('title', 'Subcategory List — TeacherHub OBE')
@section('page_title', 'Subcategory List')

@section('content')
<div class="p-hero">
    <div><div class="p-hero-h">Subcategory (Course) List</div><div class="p-hero-sub">Subcategories mapped to major categories and course codes</div></div>
    <button class="btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fas fa-plus"></i> Add Subcategory</button>
</div>

<div class="d-card" style="animation-delay:.05s">
    <div class="d-card-header">
        <div class="d-card-title"><div class="d-card-ico"><i class="fas fa-layer-group"></i></div>Subcategories Under Major Categories</div>
        <span class="badge b-green" style="padding:5px 12px;">3 records</span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl">
                <thead>
                    <tr><th style="padding-left:20px;">#</th><th>Subcategory Name</th><th>Parent Category</th><th>Course Code</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding-left:20px;"><span class="t-num">01</span></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:9px;">
                                <div style="width:7px;height:7px;border-radius:50%;background:var(--primary);box-shadow:0 0 0 2px var(--primary-subtle);flex-shrink:0;"></div>
                                <span class="t-name">Array &amp; Linked List</span>
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:7px;">
                                <div class="cat-ico" style="width:24px;height:24px;background:var(--success-lt);color:var(--success);font-size:.60rem;"><i class="fas fa-code-branch"></i></div>
                                <span class="badge b-gray">Data Structure</span>
                            </div>
                        </td>
                        <td><span class="t-code">CSE-201</span></td>
                        <td><div style="display:flex;gap:5px;">
                            <button class="btn-ico bi-ed" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fas fa-pen"></i></button>
                            <button class="btn-ico bi-del"><i class="fas fa-trash-alt"></i></button>
                        </div></td>
                    </tr>
                    <tr>
                        <td style="padding-left:20px;"><span class="t-num">02</span></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:9px;">
                                <div style="width:7px;height:7px;border-radius:50%;background:var(--purple);box-shadow:0 0 0 2px var(--purple-lt);flex-shrink:0;"></div>
                                <span class="t-name">Sorting Algorithms</span>
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:7px;">
                                <div class="cat-ico" style="width:24px;height:24px;background:var(--purple-lt);color:var(--purple);font-size:.60rem;"><i class="fas fa-sitemap"></i></div>
                                <span class="badge b-purple">Algorithm</span>
                            </div>
                        </td>
                        <td><span class="t-code">CSE-202</span></td>
                        <td><div style="display:flex;gap:5px;">
                            <button class="btn-ico bi-ed" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fas fa-pen"></i></button>
                            <button class="btn-ico bi-del"><i class="fas fa-trash-alt"></i></button>
                        </div></td>
                    </tr>
                    <tr>
                        <td style="padding-left:20px;"><span class="t-num">03</span></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:9px;">
                                <div style="width:7px;height:7px;border-radius:50%;background:var(--primary);box-shadow:0 0 0 2px var(--primary-subtle);flex-shrink:0;"></div>
                                <span class="t-name">Tree &amp; Graph</span>
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:7px;">
                                <div class="cat-ico" style="width:24px;height:24px;background:var(--success-lt);color:var(--success);font-size:.60rem;"><i class="fas fa-code-branch"></i></div>
                                <span class="badge b-gray">Data Structure</span>
                            </div>
                        </td>
                        <td><span class="t-code">CSE-201</span></td>
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

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><div class="m-ico"><i class="fas fa-plus"></i></div>Add New Subcategory</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="fg"><label class="flabel">Parent Category</label><select class="finput" style="cursor:pointer;"><option selected disabled>— Choose Category —</option><option>Data Structure</option><option>Algorithm</option></select></div>
                <div class="fg"><label class="flabel">Subcategory Name</label><input type="text" class="finput" placeholder="e.g. Stack &amp; Queue"></div>
                <div class="fg" style="margin-bottom:0;"><label class="flabel">Course Code</label><input type="text" class="finput" placeholder="e.g. CSE-201"></div>
            </div>
            <div class="modal-footer"><button class="btn-ghost" data-bs-dismiss="modal">Cancel</button><button class="btn-primary"><i class="fas fa-plus"></i> Add Subcategory</button></div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><div class="m-ico"><i class="fas fa-pen"></i></div>Edit Subcategory</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="fg"><label class="flabel">Parent Category</label><select class="finput" style="cursor:pointer;"><option selected>Data Structure</option><option>Algorithm</option></select></div>
                <div class="fg"><label class="flabel">Subcategory Name</label><input type="text" class="finput" value="Array &amp; Linked List"></div>
                <div class="fg" style="margin-bottom:0;"><label class="flabel">Course Code</label><input type="text" class="finput" value="CSE-201"></div>
            </div>
            <div class="modal-footer"><button class="btn-ghost" data-bs-dismiss="modal">Cancel</button><button class="btn-primary"><i class="fas fa-check"></i> Save Changes</button></div>
        </div>
    </div>
</div>
@endsection
