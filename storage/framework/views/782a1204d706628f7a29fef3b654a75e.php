<?php $__env->startSection('title', 'Course Info - Student Dashboard'); ?>

<?php $__env->startSection('content'); ?>

        <div class="container-fluid">
            <h2 class="mb-4">Academic Details</h2>

            <section id="course-info" class="mb-5">
                <div class="card">
                    <div class="card-header bg-white font-weight-bold">
                        <i class="fas fa-graduation-cap me-2"></i> <strong>My Course Information</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Course Code</th>
                                        <th>Course Title</th>
                                        <th>Instructor</th>
                                        <th>Course Credit</th>
                                        <th>Year</th>
                                        <th>Semester</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">CSE-0400</td>
                                        <td>System Design Project</td>
                                        <td>Dr. Ahmed</td>
                                        <td>3.0</td>
                                        <td>2025</td>
                                        <td>Spring</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/student/course.blade.php ENDPATH**/ ?>