<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\CourseMaterialController;

use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\CourseController as TeacherCourseController;
use App\Http\Controllers\Teacher\CourseMaterialController as TeacherCourseMaterialController;

use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\CourseMaterialController as StudentCourseMaterialController;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['web', 'auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/store', [AdminDashboardController::class, 'storeRecord'])->name('dashboard.store');
    Route::put('/dashboard/update/{id}', [AdminDashboardController::class, 'updateRecord'])->name('dashboard.update');
    Route::delete('/dashboard/delete/{id}', [AdminDashboardController::class, 'deleteRecord'])->name('dashboard.delete');
    
    // User Management
    Route::resource('student-info', App\Http\Controllers\Admin\StudentInfoController::class);
    Route::resource('teacher-info', App\Http\Controllers\Admin\TeacherController::class);
    Route::post('departments/store', [App\Http\Controllers\Admin\TeacherController::class, 'storeDepartment'])->name('departments.store');
    Route::resource('admins', App\Http\Controllers\Admin\AdminController::class);
    
    // Core Data
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubcategoryController::class);
    Route::resource('semesters', App\Http\Controllers\Admin\SemesterController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('course-materials', CourseMaterialController::class);
});

// Teacher Routes
Route::middleware(['web', 'auth', 'is_teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
    Route::resource('courses', TeacherCourseController::class)->only(['index', 'show']);
    Route::resource('course-materials', TeacherCourseMaterialController::class);
});

// Student Routes
Route::middleware(['web', 'auth', 'is_student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::resource('courses', StudentCourseController::class)->only(['index', 'show']);
    Route::resource('course-materials', StudentCourseMaterialController::class)->only(['index']);
    Route::get('/course-materials/{material}/download', [StudentCourseMaterialController::class, 'download'])->name('course-materials.download');
});
