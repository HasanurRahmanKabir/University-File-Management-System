<?php $__env->startSection('title', 'Upload Materials — TeacherHub OBE'); ?>
<?php $__env->startSection('page_title', 'Upload Materials'); ?>

<?php $__env->startPush('styles'); ?>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
    /* Ensure TomSelect matches the standard professional design */
    .ts-wrapper.custom-ts { display: block !important; width: 100% !important; padding: 0 !important; border: none !important; background: transparent !important; box-shadow: none !important; margin: 0; }
    .ts-wrapper.custom-ts .ts-control { border: 1px solid #cbd5e1 !important; border-radius: 8px !important; background-color: #f8fafc !important; background-image: none !important; color: #334155 !important; font-size: 0.9rem !important; font-weight: 500 !important; padding: 10px 15px !important; min-height: 44px !important; box-shadow: none !important; display: flex !important; flex-wrap: wrap; align-items: center; gap: 4px; transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease; }
    .ts-wrapper.custom-ts.focus .ts-control { border-color: var(--primary) !important; background-color: #ffffff !important; box-shadow: 0 0 0 3px var(--primary-light) !important; outline: 0 !important; }
    .ts-dropdown { border: 1px solid #cbd5e1 !important; border-radius: 8px !important; background-color: #ffffff !important; box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important; z-index: 9999 !important; overflow: hidden; }
    .ts-dropdown .ts-dropdown-content { max-height: 250px !important; overflow-y: auto !important; padding: 5px 0; }
    .ts-dropdown .option[data-value=""] { display: none !important; }
    .ts-dropdown .option { padding: 8px 15px !important; color: #475569 !important; font-size: 0.9rem !important; cursor: pointer; }
    .ts-dropdown .option:hover, .ts-dropdown .active { background-color: #f1f5f9 !important; color: var(--primary) !important; }
    .ts-dropdown .dropdown-input-wrap { padding: 10px !important; border-bottom: 1px solid #e2e8f0 !important; background: #f8fafc; }
    .ts-dropdown .dropdown-input { border: 1px solid #cbd5e1 !important; border-radius: 6px !important; padding: 8px 12px !important; background: #ffffff !important; color: #334155 !important; font-size: 0.9rem !important; }
    .ts-dropdown .dropdown-input:focus { border-color: var(--primary) !important; outline: none; }
    .ts-control::after { content: ""; display: block; width: 8px; height: 8px; border-right: 2px solid #64748b; border-bottom: 2px solid #64748b; transform: rotate(45deg); position: absolute; right: 15px; top: 42%; transition: transform 0.2s ease; }
    .ts-wrapper.dropdown-active .ts-control::after { transform: rotate(-135deg); top: 48%; }
    .ts-wrapper.dropdown-active .ts-control .item, .ts-wrapper.has-items .ts-control .item { display: block !important; opacity: 1 !important; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">

    <!-- Upload Form -->
    <div class="col-xl-5 col-lg-5 col-12">
        <div class="d-card" style="animation-delay:.05s">
            <div class="d-card-header">
                <div class="d-card-title"><div class="d-card-ico"><i class="fas fa-cloud-arrow-up"></i></div>Add New File</div>
            </div>
            <div class="d-card-body">
                <form action="<?php echo e(route('teacher.course-materials.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="fg">
                        <label class="flabel">Select Course</label>
                        <select class="finput" style="cursor:pointer;" name="course_id" id="add_course_id" required>
                            <option selected disabled value="">— Select Course —</option>
                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($course->id); ?>"><?php echo e($course->course_code); ?> — <?php echo e($course->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="fg">
                        <label class="flabel">Material Title</label>
                        <input type="text" class="finput" name="title" placeholder="e.g. Lecture 01 — Introduction" required>
                    </div>
                    <div class="fg">
                        <label class="flabel">File Privacy</label>
                        <div class="priv-seg">
                            <input type="radio" name="is_active" value="1" id="pub" checked>
                            <label for="pub"><i class="fas fa-globe" style="font-size:.72rem;"></i> Public</label>
                            <input type="radio" name="is_active" value="0" id="me">
                            <label for="me"><i class="fas fa-lock" style="font-size:.70rem;"></i> Only Me</label>
                        </div>
                    </div>
                    <div class="fg">
                        <label class="flabel">Upload File</label>
                        <div class="upload-z" id="dropZone" onclick="document.getElementById('fileIn').click()">
                            <div class="upload-z-ico"><i class="fas fa-file-arrow-up"></i></div>
                            <div class="upload-z-txt" id="fileText">Click or drag &amp; drop your file here</div>
                            <div class="upload-z-hint">PDF · DOCX · PPTX — Max 20 MB</div>
                            <input type="file" hidden id="fileIn" name="file" required onchange="document.getElementById('fileText').innerText = this.files[0].name">
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
                <span class="badge b-green" style="padding:5px 12px;"><?php echo e($materials->total()); ?> file<?php echo e($materials->total() !== 1 ? 's' : ''); ?></span>
            </div>
            <div class="d-card-body p0">
                <div class="t-wrap">
                    <table class="t-tbl">
                        <thead><tr><th>File Info</th><th style="text-align:center;">Course</th><th style="text-align:center;">Privacy</th><th style="text-align:center;">Action</th></tr></thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <?php
                                            $ext = strtolower($material->file_type);
                                            $ico = 'fa-file-alt'; $bg = 'var(--bg-muted)'; $col = 'var(--tx-s)';
                                            if($ext === 'pdf') { $ico = 'fa-file-pdf'; $bg = 'var(--danger-lt)'; $col = 'var(--danger)'; }
                                            elseif(in_array($ext, ['doc','docx'])) { $ico = 'fa-file-word'; $bg = 'var(--info-lt)'; $col = 'var(--info)'; }
                                            elseif(in_array($ext, ['ppt','pptx'])) { $ico = 'fa-file-powerpoint'; $bg = 'var(--warning-lt)'; $col = 'var(--warning)'; }
                                        ?>
                                        <div class="cat-ico" style="width:34px;height:34px;background:<?php echo e($bg); ?>;color:<?php echo e($col); ?>;">
                                            <i class="fas <?php echo e($ico); ?>" style="font-size:.85rem;"></i>
                                        </div>
                                        <div>
                                            <div class="t-name" style="font-size:.82rem;">
                                                <a href="<?php echo e(Storage::url($material->file_path)); ?>" target="_blank" style="color:inherit;text-decoration:none;"><?php echo e($material->title); ?></a>
                                            </div>
                                            <div class="t-sub"><?php echo e(strtoupper($ext)); ?> · <?php echo e(number_format($material->file_size / 1024 / 1024, 2)); ?> MB</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:center;"><span class="badge b-blue"><?php echo e($material->course->course_code); ?></span></td>
                                <td style="text-align:center;">
                                    <?php if($material->is_active): ?>
                                    <span class="badge b-green"><i class="fas fa-globe"></i> Public</span>
                                    <?php else: ?>
                                    <span class="badge b-gray"><i class="fas fa-lock"></i> Only Me</span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align:center;"><div style="display:flex;gap:5px;justify-content:center;">
                                    <button type="button" class="btn-ico bi-ed" data-bs-toggle="modal" data-bs-target="#editModal" onclick="populateEditModal(<?php echo e($material->id); ?>, '<?php echo e(addslashes($material->title)); ?>', <?php echo e($material->course_id); ?>, <?php echo e($material->is_active ? 1 : 0); ?>)"><i class="fas fa-pen"></i></button>
                                    <form action="<?php echo e(route('teacher.course-materials.destroy', $material->id)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="btn-ico bi-del delete-btn" type="submit"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state d-flex flex-column align-items-center justify-content-center" style="padding: 40px 20px; text-align: center;">
                                        <div class="empty-ico" style="font-size: 3rem; color: var(--bd-dark, #cbd5e1); margin-bottom: 15px;"><i class="fas fa-box-open"></i></div>
                                        <h5 style="color: var(--tx-h); font-weight: 600; margin-bottom: 5px;">No Materials Found</h5>
                                        <p style="color: var(--tx-m); font-size: 0.9rem; max-width: 400px; margin: 0 auto;">You have not uploaded any materials for your courses yet.</p>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('modals'); ?>
<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="modal-header"><h5 class="modal-title"><div class="m-ico"><i class="fas fa-pen"></i></div>Edit Material Info</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="fg">
                        <label class="flabel">Material Title</label>
                        <input type="text" class="finput" name="title" id="edit_title" required>
                    </div>
                    <div class="fg">
                        <label class="flabel">Select Course</label>
                        <select class="finput" style="cursor:pointer;" name="course_id" id="edit_course_id" required>
                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($course->id); ?>"><?php echo e($course->course_code); ?> — <?php echo e($course->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="fg" style="margin-bottom:0;">
                        <label class="flabel">Privacy</label>
                        <select class="finput" style="cursor:pointer;" name="is_active" id="edit_privacy" required>
                            <option value="1">Public</option>
                            <option value="0">Only Me</option>
                        </select>
                    </div>
                    <div class="fg" style="margin-top:15px;">
                        <label class="flabel">Replace File (Optional)</label>
                        <div class="upload-z" id="dropZoneEdit" onclick="document.getElementById('fileInEdit').click()">
                            <div class="upload-z-ico"><i class="fas fa-file-arrow-up"></i></div>
                            <div class="upload-z-txt" id="fileTextEdit">Click or drag &amp; drop to replace file</div>
                            <div class="upload-z-hint">PDF · DOCX · PPTX — Max 20 MB</div>
                            <input type="file" hidden id="fileInEdit" name="file" onchange="document.getElementById('fileTextEdit').innerText = this.files[0].name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn-ghost" data-bs-dismiss="modal" style="padding: 9px 20px; font-size: 0.82rem; font-weight: 600; box-shadow: inset 0 0 0 1px #cbd5e1, 0 1px 3px rgba(0,0,0,0.1); background-color: #ffffff; color: #475569; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f1f5f9'" onmouseout="this.style.backgroundColor='#ffffff'">Cancel</button><button type="submit" class="btn-primary"><i class="fas fa-check"></i> Save Changes</button></div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    let editCourseSelect;
    let editPrivacySelect;

    document.addEventListener('DOMContentLoaded', function() {
        let tsConfig = {
            create: false,
            controlInput: null,
            maxOptions: null,
            allowEmptyOption: true,
            wrapperClass: 'ts-wrapper custom-ts',
            plugins: ['dropdown_input'],
            sortField: { field: "text", direction: "asc" },
            onDelete: function(values, e) { return e ? false : true; }
        };

        let addCourseSelect = new TomSelect('#add_course_id', tsConfig);
        let searchInputAdd = addCourseSelect.dropdown.querySelector('input');
        if(searchInputAdd) searchInputAdd.setAttribute('placeholder', 'Search course...');

        editCourseSelect = new TomSelect('#edit_course_id', tsConfig);
        let searchInputEdit = editCourseSelect.dropdown.querySelector('input');
        if(searchInputEdit) searchInputEdit.setAttribute('placeholder', 'Search course...');

        let tsConfigNoSearch = {
            create: false,
            controlInput: null,
            maxOptions: null,
            wrapperClass: 'ts-wrapper custom-ts',
            onDelete: function(values, e) { return e ? false : true; },
            render: {
                option: function(data, escape) {
                    if (data.value === "1") {
                        return '<div class="px-2 py-1"><span class="badge b-green" style="font-size:0.85rem; padding:6px 12px;"><i class="fas fa-globe"></i> ' + escape(data.text) + '</span></div>';
                    } else {
                        return '<div class="px-2 py-1"><span class="badge b-gray" style="font-size:0.85rem; padding:6px 12px;"><i class="fas fa-lock"></i> ' + escape(data.text) + '</span></div>';
                    }
                },
                item: function(data, escape) {
                    if (data.value === "1") {
                        return '<div style="font-size:0.95rem; font-weight:600; color: #059669; display:flex; align-items:center; gap:6px;"><i class="fas fa-globe"></i> ' + escape(data.text) + '</div>';
                    } else {
                        return '<div style="font-size:0.95rem; font-weight:600; color: #475569; display:flex; align-items:center; gap:6px;"><i class="fas fa-lock"></i> ' + escape(data.text) + '</div>';
                    }
                }
            }
        };
        editPrivacySelect = new TomSelect('#edit_privacy', tsConfigNoSearch);
    });
    const dz=document.getElementById('dropZone');
    if(dz) {
        ['dragover','dragenter'].forEach(e=>dz.addEventListener(e,ev=>{ev.preventDefault();dz.style.borderColor='var(--primary)';dz.style.background='var(--primary-light)';}));
        ['dragleave','drop'].forEach(e=>dz.addEventListener(e,ev=>{ev.preventDefault();dz.style.borderColor='';dz.style.background='';}));
    }

    const dzEdit=document.getElementById('dropZoneEdit');
    if(dzEdit) {
        ['dragover','dragenter'].forEach(e=>dzEdit.addEventListener(e,ev=>{ev.preventDefault();dzEdit.style.borderColor='var(--primary)';dzEdit.style.background='var(--primary-light)';}));
        ['dragleave','drop'].forEach(e=>dzEdit.addEventListener(e,ev=>{ev.preventDefault();dzEdit.style.borderColor='';dzEdit.style.background='';}));
    }

    function populateEditModal(id, title, courseId, isActive) {
        document.getElementById('editForm').action = `/teacher/course-materials/${id}`;
        document.getElementById('edit_title').value = title;
        if(editCourseSelect) {
            editCourseSelect.setValue(courseId);
        } else {
            document.getElementById('edit_course_id').value = courseId;
        }
        if(editPrivacySelect) {
            editPrivacySelect.setValue(String(isActive));
        } else {
            document.getElementById('edit_privacy').value = isActive;
        }
        
        document.getElementById('fileInEdit').value = '';
        document.getElementById('fileTextEdit').innerText = 'Click or drag & drop to replace file';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This material file will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Yes, delete!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/teacher/uploadmaterials.blade.php ENDPATH**/ ?>