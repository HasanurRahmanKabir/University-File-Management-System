<?php
namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        // 1. Active Courses
        $activeCoursesCount = Course::where('teacher_id', $teacherId)
            ->where('is_active', true)
            ->count();

        // 2. Total Uploads
        $totalUploads = CourseMaterial::whereHas('course', function($q) use ($teacherId) { 
            $q->where('teacher_id', $teacherId); 
        })->count();

        // 3. Total Students (across all teacher's courses)
        $teacherCourseIds = Course::where('teacher_id', $teacherId)->pluck('id')->toArray();
        $totalStudents = \App\Models\User::where('role', 'student')->get()->filter(function ($student) use ($teacherCourseIds) {
            $enrolled = is_string($student->enrolled_courses) ? json_decode($student->enrolled_courses, true) : $student->enrolled_courses;
            if (!is_array($enrolled)) return false;
            return count(array_intersect($enrolled, $teacherCourseIds)) > 0;
        })->count();

        // 4. Recent Courses Table
        $recentCourses = Course::where('teacher_id', $teacherId)
            ->withCount('materials')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($course) {
                $course->enrolled_students = \App\Models\User::where('role', 'student')->get()->filter(function ($student) use ($course) {
                    $enrolled = is_string($student->enrolled_courses) ? json_decode($student->enrolled_courses, true) : $student->enrolled_courses;
                    return is_array($enrolled) && in_array($course->id, $enrolled);
                })->count();
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