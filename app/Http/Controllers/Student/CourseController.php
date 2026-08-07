<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        // Get enrolled course IDs and strictly ensure it's an array to prevent SQL errors
        $enrolledIds = $user->enrolled_courses ? json_decode($user->enrolled_courses, true) : [];
        if (!is_array($enrolledIds)) {
            $enrolledIds = [];
        }
        
        $courses = Course::with(['category', 'subcategory', 'teacher'])
            ->whereIn('id', $enrolledIds)
            ->where('is_active', true)
            ->latest()
            ->paginate(12);
            
        return view('student.courses.index', compact('courses'));
    }
}