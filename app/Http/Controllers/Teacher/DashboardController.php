<?php
namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();
        $teacherDepartmentId = Auth::user()->department_id;

        // 1. Active Courses (in running semesters)
        $activeSemesterIds = \App\Models\Semester::running($teacherDepartmentId)->pluck('id')->toArray();
        $activeCoursesCount = Course::where('teacher_id', $teacherId)
            ->where('is_active', true)
            ->whereIn('semester_id', $activeSemesterIds)
            ->count();

        // 2. Total Uploads
        $totalUploads = CourseMaterial::whereHas('course', function($q) use ($teacherId) { 
            $q->where('teacher_id', $teacherId); 
        })->count();

        // 3. Total Students (across all teacher's courses)
        $teacherCourseIds = Course::where('teacher_id', $teacherId)->pluck('id')->toArray();
        $totalStudents = 0;
        if (!empty($teacherCourseIds)) {
            $totalStudents = User::where('role', 'student')
                ->whereHas('enrolledCourses', function ($q) use ($teacherCourseIds) {
                    $q->whereIn('courses.id', $teacherCourseIds);
                })->count();
        }

        // 4. Recent Courses Table
        $recentCourses = Course::with(['semester', 'department'])
            ->where('teacher_id', $teacherId)
            ->withCount('materials')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($course) {
                $course->enrolled_students = $course->enrolledStudents()->count();
                return $course;
            });

        return view('teacher.dashboard', compact(
            'activeCoursesCount', 
            'totalUploads', 
            'totalStudents', 
            'recentCourses'
        ));
    }
}