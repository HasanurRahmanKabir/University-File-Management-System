@extends('layouts.teacher')

@section('title', 'Category List — TeacherHub OBE')
@section('page_title', 'Category List')

@section('content')
<div class="p-hero">
    <div><div class="p-hero-h">Course Categories</div><div class="p-hero-sub">Browse and manage major course categories</div></div>
    <button class="btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fas fa-plus"></i> Add Category</button>
</div>

<div class="d-card" style="animation-delay:.05s">
    <div class="d-card-header">
        <div class="d-card-title"><div class="d-card-ico"><i class="fas fa-tags"></i></div>Major Categories</div>
        <span class="badge b-green" style="padding:5px 12px;">2 categories</span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl">
                <thead>
                    <tr><th style="padding-left:20px;">#</th><th>Category Name</th><th>Subcategories</th><th>Description</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding-left:20px;"><span class="t-num">01</span></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div class="cat-ico" style="width:34px;height:34px;background:var(--success-lt);color:var(--success);">
                                    <i class="fas fa-code-branch" style="font-size:.76rem;"></i>
                                </div>
                                <span class="t-name">Data Structure</span>
                            </div>
                        </td>
                        <td><span class="badge b-blue">06 Subcategories</span></td>
                        <td style="color:var(--tx-s);font-size:.80rem;max-width:220px;">Linear and Non-linear data organization.</td>
                        <td><div style="display:flex;gap:5px;">
                            <button class="btn-ico bi-ed" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fas fa-pen"></i></button>
                            <button class="btn-ico bi-del"><i class="fas fa-trash-alt"></i></button>
                        </div></td>
                    </tr>
                    <tr>
                        <td style="padding-left:20px;"><span class="t-num">02</span></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div class="cat-ico" style="width:34px;height:34px;background:var(--purple-lt);color:var(--purple);">
                                    <i class="fas fa-sitemap" style="font-size:.76rem;"></i>
                                </div>
                                <span class="t-name">Algorithm</span>
                            </div>
                        </td>
                        <td><span class="badge b-purple">04 Subcategories</span></td>
                        <td style="color:var(--tx-s);font-size:.80rem;max-width:220px;">Design and Analysis of Computational Algorithms.</td>
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
            <div class="modal-header"><h5 class="modal-title"><div class="m-ico"><i class="fas fa-plus"></i></div>Add New Category</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="fg"><label class="flabel">Category Name</label><input type="text" class="finput" placeholder="e.g. Database Systems"></div>
                <div class="fg" style="margin-bottom:0;"><label class="flabel">Short Description</label><textarea class="finput" rows="3" placeholder="Brief about this category..." style="resize:vertical;"></textarea></div>
            </div>
            <div class="modal-footer"><button class="btn-ghost" data-bs-dismiss="modal">Cancel</button><button class="btn-primary"><i class="fas fa-plus"></i> Create Category</button></div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><div class="m-ico"><i class="fas fa-pen"></i></div>Edit Category Info</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="fg"><label class="flabel">Category Name</label><input type="text" class="finput" value="Data Structure"></div>
                <div class="fg" style="margin-bottom:0;"><label class="flabel">Description</label><textarea class="finput" rows="3" style="resize:vertical;">Linear and Non-linear data organization.</textarea></div>
            </div>
            <div class="modal-footer"><button class="btn-ghost" data-bs-dismiss="modal">Cancel</button><button class="btn-primary"><i class="fas fa-check"></i> Save Changes</button></div>
        </div>
    </div>
</div>
@endsection
