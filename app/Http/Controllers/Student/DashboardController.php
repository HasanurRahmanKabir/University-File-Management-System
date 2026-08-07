<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get enrolled course IDs and strictly ensure it's an array to prevent SQL errors
        $enrolledIds = $user->enrolled_courses ? json_decode($user->enrolled_courses, true) : [];
        if (!is_array($enrolledIds)) {
            $enrolledIds = [];
        }
        
        // Fetch the student's courses
        $myCourses = Course::with('teacher')->whereIn('id', $enrolledIds)->get();
        
        // Count materials uploaded only for this student's enrolled courses
        $materialsCount = CourseMaterial::whereIn('course_id', $enrolledIds)->count();

        // Since there is no assignments logic in the database yet, this defaults to 0
        $assignmentsCount = 0;

        $stats = [
            'courses' => $myCourses->count(),
            'materials' => $materialsCount,
            'assignments' => $assignmentsCount,
        ];
        
        // Pass latest 5 courses for the table
        $recentCourses = $myCourses->take(5);

        return view('student.dashboard', compact('stats', 'recentCourses'));
    }
}