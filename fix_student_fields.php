<?php
$file = 'resources/views/admin/student.blade.php';
$content = file_get_contents($file);

$search = '<div class="col-md-6">
                                <label class="form-label fw-semibold">Student Name</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="text" class="form-control" required>
                            </div>';

$replace = '<div class="col-md-6">
                                <label class="form-label fw-semibold">Student Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Student Name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                            </div>';

$content = str_replace($search, $replace, $content);
file_put_contents($file, $content);
echo "Fixed Student fields via PHP script!\n";
