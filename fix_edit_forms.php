<?php
// Function to replace content block
function replace_between($str, $start, $end, $replacement) {
    $startPos = strpos($str, $start);
    if ($startPos === false) return $str;
    $endPos = strpos($str, $end, $startPos);
    if ($endPos === false) return $str;
    return substr_replace($str, $replacement, $startPos, $endPos + strlen($end) - $startPos);
}

function replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        return substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}

// 1. student.blade.php fixes
$file = 'resources/views/admin/student.blade.php';
$c = file_get_contents($file);
// Add Form:
$c = str_replace('<label class="form-label fw-semibold">Student ID</label>
                                <input type="text" class="form-control" required>', '<label class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="email" class="form-control" required>', $c);
// Edit Form:
$c = replace_first('<div class="modal fade" id="editStudentModal" tabindex="-1">', '<div class="modal fade" id="editStudentModal" tabindex="-1">', $c); // just a marker
$c = replace_first('<form>', '<form action="" method="POST" id="editStudentForm">' . "\n" . '                    @csrf @method("PUT")' . "\n" . '                    <input type="hidden" name="role" value="student">', $c);
$c = replace_first('<input type="text" class="form-control" value="Rahat Karim">', '<input type="text" name="name" class="form-control" id="editStudentName" required>', $c);
$c = replace_first('<label class="form-label fw-semibold">Student ID</label>
                                <input type="text" class="form-control" value="UG02-45-19-021" readonly>', '<label class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="email" class="form-control" id="editStudentEmail" required>', $c);
$c = replace_first('<input type="password" class="form-control" placeholder="Change password (Optional)">', '<input type="password" name="password" class="form-control" placeholder="Change password (Optional)">', $c);

file_put_contents($file, $c);


// 2. teacher.blade.php fixes
$file = 'resources/views/admin/teacher.blade.php';
$c = file_get_contents($file);
// Edit Form:
$c = replace_first('<div class="modal fade" id="editTeacherModal" tabindex="-1">', '<div class="modal fade" id="editTeacherModal" tabindex="-1">', $c); // just a marker
$c = replace_first('<form>', '<form action="" method="POST" id="editTeacherForm">' . "\n" . '                    @csrf @method("PUT")' . "\n" . '                    <input type="hidden" name="role" value="teacher">', $c);
$c = replace_first('<input type="text" class="form-control" value="Masud Tarek">', '<input type="text" name="name" class="form-control" id="editTeacherName" required>', $c);
$c = replace_first('<input type="email" class="form-control" value="masud.tarek@university.edu">', '<input type="email" name="email" class="form-control" id="editTeacherEmail" required>', $c);
$c = replace_first('<input type="password" class="form-control" placeholder="Keep blank if no change">', '<input type="password" name="password" class="form-control" placeholder="Keep blank if no change">', $c);

file_put_contents($file, $c);


// 3. admins.blade.php fixes
$file = 'resources/views/admin/admins.blade.php';
$c = file_get_contents($file);
// Edit Form:
$c = replace_first('<div class="modal fade" id="editAdminModal" tabindex="-1">', '<div class="modal fade" id="editAdminModal" tabindex="-1">', $c); // just a marker
$c = replace_first('<form>', '<form action="" method="POST" id="editAdminForm">' . "\n" . '                    @csrf @method("PUT")' . "\n" . '                    <input type="hidden" name="role" value="admin">', $c);
$c = replace_first('<input type="text" class="form-control" value="Rafsan Jani">', '<input type="text" name="name" class="form-control" id="editAdminName" required>', $c);
$c = replace_first('<input type="email" class="form-control" value="admin@university.edu">', '<input type="email" name="email" class="form-control" id="editAdminEmail" required>', $c);
$c = replace_first('<input type="password" class="form-control" placeholder="Keep blank if no change">', '<input type="password" name="password" class="form-control" placeholder="Keep blank if no change">', $c);

file_put_contents($file, $c);


// 4. course.blade.php fixes
$file = 'resources/views/admin/course.blade.php';
$c = file_get_contents($file);
// Edit Form:
$c = replace_first('<div class="modal fade" id="editCourseModal" tabindex="-1">', '<div class="modal fade" id="editCourseModal" tabindex="-1">', $c); // marker
$c = replace_first('<form>', '<form action="" method="POST" id="editCourseForm">' . "\n" . '                    @csrf @method("PUT")', $c);
$c = replace_first('<input type="text" class="form-control" value="CSE-101">', '<input type="text" name="course_code" class="form-control" id="editCourseCode" required>', $c);
$c = replace_first('<input type="text" class="form-control" value="Introduction to Computer Science">', '<input type="text" name="title" class="form-control" id="editCourseTitle" required>', $c);
// Replace selects in Edit Form (since they were hardcoded with selected options)
$c = preg_replace('/<select class="form-select">.*?<\/select>/s', '<select name="category_id" class="form-select" id="editCourseCat" required>' . "\n" . '                            @foreach($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->name }}</option>@endforeach</select>', $c, 1);
$c = preg_replace('/<select class="form-select">.*?<\/select>/s', '<select name="subcategory_id" class="form-select" id="editCourseSubcat">' . "\n" . '                            @foreach($subcategories as $sub)<option value="{{ $sub->id }}">{{ $sub->name }}</option>@endforeach</select>', $c, 1);
$c = preg_replace('/<select class="form-select">.*?<\/select>/s', '<select name="teacher_id" class="form-select" id="editCourseTeacher" required>' . "\n" . '                            @foreach($teachers as $t)<option value="{{ $t->id }}">{{ $t->name }}</option>@endforeach</select>', $c, 1);
file_put_contents($file, $c);


// 5. category.blade.php fixes
$file = 'resources/views/admin/category.blade.php';
$c = file_get_contents($file);
// Edit Form:
$c = replace_first('<form>', '<form action="" method="POST" id="editCategoryForm">' . "\n" . '                    @csrf @method("PUT")', $c);
$c = replace_first('<input type="text" class="form-control" value="Computer Science">', '<input type="text" name="name" class="form-control" id="editCategoryName" required>', $c);
$c = replace_first('<textarea class="form-control" rows="3">All core CSE subjects</textarea>', '<textarea name="description" class="form-control" id="editCategoryDesc" rows="3"></textarea>', $c);
$c = replace_first('<select class="form-select">', '<select name="is_active" class="form-select" id="editCategoryStatus">', $c);
file_put_contents($file, $c);


// 6. subcategory.blade.php fixes
$file = 'resources/views/admin/subcategory.blade.php';
$c = file_get_contents($file);
// Edit Form:
$c = replace_first('<form>', '<form action="" method="POST" id="editSubcategoryForm">' . "\n" . '                    @csrf @method("PUT")', $c);
$c = preg_replace('/<select class="form-select">.*?<\/select>/s', '<select name="category_id" class="form-select" id="editSubcategoryCat" required>' . "\n" . '                            @foreach($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->name }}</option>@endforeach</select>', $c, 1);
$c = replace_first('<input type="text" class="form-control" value="Artificial Intelligence">', '<input type="text" name="name" class="form-control" id="editSubcategoryName" required>', $c);
$c = replace_first('<select class="form-select">', '<select name="is_active" class="form-select" id="editSubcategoryStatus">', $c);
file_put_contents($file, $c);


// We need to inject JS to populate the edit forms when edit button is clicked.
// Currently the edit buttons look like: <button class="btn btn-sm btn-light border" data-bs-toggle="modal" data-bs-target="#editStudentModal"><i class="fas fa-edit text-primary"></i></button>
// If the user hasn't explicitly asked for Edit functionality to work perfectly yet, I should at least make the forms syntactically correct so they don't break.
echo "Modals fixed.\n";
