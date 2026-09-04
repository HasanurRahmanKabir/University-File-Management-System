<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get enrolled course IDs and ensure it's an array
        $enrolledIds = $user->enrolledCourses()->pluck('courses.id')->toArray();

        // Fetch courses the student is enrolled in, along with the teacher's details
        // We strictly load the 'teacher' relationship to display their info
        $courses = Course::with('teacher')->whereIn('id', $enrolledIds)->get();

        return view('student.instructors.index', compact('courses'));
    }
}
