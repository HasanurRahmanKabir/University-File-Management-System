<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();
        $allStudents = \App\Models\User::where('role', 'student')->get();

        $runningCourses = Course::with(['category', 'subcategory'])->where('teacher_id', $teacherId)->where('is_active', true)->latest()->get()->map(function($course) use ($allStudents) {
            $course->enrolled_students = $allStudents->filter(function ($student) use ($course) {
                $enrolled = is_string($student->enrolled_courses) ? json_decode($student->enrolled_courses, true) : $student->enrolled_courses;
                return is_array($enrolled) && in_array($course->id, $enrolled);
            })->count();
            return $course;
        });

        $previousCourses = Course::with(['category', 'subcategory'])->where('teacher_id', $teacherId)->where('is_active', false)->latest()->get()->map(function($course) use ($allStudents) {
            $course->enrolled_students = $allStudents->filter(function ($student) use ($course) {
                $enrolled = is_string($student->enrolled_courses) ? json_decode($student->enrolled_courses, true) : $student->enrolled_courses;
                return is_array($enrolled) && in_array($course->id, $enrolled);
            })->count();
            return $course;
        });

        $activeCoursesCount = $runningCourses->count();
        
        $teacherCourseIds = Course::where('teacher_id', $teacherId)->pluck('id')->toArray();
        $totalStudents = $allStudents->filter(function ($student) use ($teacherCourseIds) {
            $enrolled = is_string($student->enrolled_courses) ? json_decode($student->enrolled_courses, true) : $student->enrolled_courses;
            if (!is_array($enrolled)) return false;
            return count(array_intersect($enrolled, $teacherCourseIds)) > 0;
        })->count();

        return view('teacher.mycourseinfo', compact('runningCourses', 'previousCourses', 'activeCoursesCount', 'totalStudents'));
    }

    public function show(Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }
        $course->load('materials');
        return view('teacher.course-detail', compact('course'));
    }
}