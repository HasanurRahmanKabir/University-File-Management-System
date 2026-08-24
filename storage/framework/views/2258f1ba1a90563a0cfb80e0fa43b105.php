<?php $__env->startSection('title', 'Subcategory List - Student Dashboard'); ?>

<?php $__env->startSection('content'); ?>

        <div class="container-fluid">
            <h2 class="mb-4 fw-bold">Subcategory Course List</h2>

            <section id="subcategory-list">
                <div class="card">
                    <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-layer-group me-2 text-info"></i> <strong>General & Management Courses</strong></span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-header-custom text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Course Name</th>
                                        <th>Subcategory Type</th>
                                        <th>Description</th>
                                        <th>Credit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td>01</td>
                                        <td class="fw-bold">Economics</td>
                                        <td>Social Science</td>
                                        <td>Micro and Macro economics basics</td>
                                        <td><span class="badge bg-light text-dark border">2.0</span></td>
                                    </tr>
                                    <tr class="text-center">
                                        <td>02</td>
                                        <td class="fw-bold">Industrial Management</td>
                                        <td>Business</td>
                                        <td>Industrial operations and HR management</td>
                                        <td><span class="badge bg-light text-dark border">3.0</span></td>
                                    </tr>
                                    <tr class="text-center">
                                        <td>03</td>
                                        <td class="fw-bold">Engineering Ethics</td>
                                        <td>Humanities</td>
                                        <td>Professional ethics and responsibilities</td>
                                        <td><span class="badge bg-light text-dark border">2.0</span></td>
                                    </tr>
                                    <tr class="text-center">
                                        <td>04</td>
                                        <td class="fw-bold">Accounting</td>
                                        <td>Business</td>
                                        <td>Financial record keeping and principles</td>
                                        <td><span class="badge bg-light text-dark border">3.0</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views\student\subcategory.blade.php ENDPATH**/ ?>