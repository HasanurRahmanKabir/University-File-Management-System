<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['category', 'subcategory', 'teacher'])->where('is_active', true)->latest()->paginate(12);
        return view('student.course', compact('courses'));
    }
}