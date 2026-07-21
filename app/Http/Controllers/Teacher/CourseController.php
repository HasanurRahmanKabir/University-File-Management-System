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
        $courses = Course::with(['category', 'subcategory'])->where('teacher_id', Auth::id())->latest()->paginate(10);
        return view('teacher.my-course', compact('courses'));
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