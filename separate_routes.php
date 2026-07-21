<?php
// separate routes

$routesFile = 'routes/web.php';
$content = file_get_contents($routesFile);

// Replace user resource with separate routes
$oldUsersRoute = "Route::resource('users', UserController::class);";
$newUsersRoute = "Route::resource('student-info', App\Http\Controllers\Admin\StudentController::class);
    Route::resource('teacher-info', App\Http\Controllers\Admin\TeacherController::class);
    Route::resource('admins', App\Http\Controllers\Admin\AdminController::class);";

$content = str_replace($oldUsersRoute, $newUsersRoute, $content);

file_put_contents($routesFile, $content);

// Now update AdminLayout Sidebar

$layoutFile = 'resources/views/layouts/admin.blade.php';
$layoutContent = file_get_contents($layoutFile);

$oldStudentLink = '<li class="nav-item"><a href="{{ route(\'admin.users.index\', [\'role\'=>\'student\']) }}" class="nav-link {{ request()->fullUrlIs(\'*role=student*\') ? \'active\' : \'\' }}"><i class="fas fa-user-graduate"></i> Student info</a></li>';
$newStudentLink = '<li class="nav-item"><a href="{{ route(\'admin.student-info.index\') }}" class="nav-link {{ request()->routeIs(\'admin.student-info.*\') ? \'active\' : \'\' }}"><i class="fas fa-user-graduate"></i> Student info</a></li>';
$layoutContent = str_replace($oldStudentLink, $newStudentLink, $layoutContent);

$oldTeacherLink = '<li class="nav-item"><a href="{{ route(\'admin.users.index\', [\'role\'=>\'teacher\']) }}" class="nav-link {{ request()->fullUrlIs(\'*role=teacher*\') ? \'active\' : \'\' }}"><i class="fas fa-user-tie"></i> Teacher info</a></li>';
$newTeacherLink = '<li class="nav-item"><a href="{{ route(\'admin.teacher-info.index\') }}" class="nav-link {{ request()->routeIs(\'admin.teacher-info.*\') ? \'active\' : \'\' }}"><i class="fas fa-user-tie"></i> Teacher info</a></li>';
$layoutContent = str_replace($oldTeacherLink, $newTeacherLink, $layoutContent);

$oldAdminLink = '<li class="nav-item"><a href="{{ route(\'admin.users.index\', [\'role\'=>\'admin\']) }}" class="nav-link {{ request()->fullUrlIs(\'*role=admin*\') ? \'active\' : \'\' }}"><i class="fas fa-user-shield"></i> Admins</a></li>';
$newAdminLink = '<li class="nav-item"><a href="{{ route(\'admin.admins.index\') }}" class="nav-link {{ request()->routeIs(\'admin.admins.*\') ? \'active\' : \'\' }}"><i class="fas fa-user-shield"></i> Admins</a></li>';
$layoutContent = str_replace($oldAdminLink, $newAdminLink, $layoutContent);

file_put_contents($layoutFile, $layoutContent);
echo "Routes and Admin Layout Updated\n";
