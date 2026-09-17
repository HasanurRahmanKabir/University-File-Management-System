<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseFolder;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get enrolled course IDs and strictly ensure it's an array to prevent SQL errors
        $enrolledIds = $user->enrolledCourses()->pluck('courses.id')->toArray();
        
        // Fetch the student's courses
        $myCourses = Course::with(['teacher', 'semester'])->whereIn('id', $enrolledIds)->get();
        
        // Count only student-visible materials (file Only Me + private folder trees stay hidden)
        $visibleFolderIds = collect($enrolledIds)
            ->flatMap(fn ($courseId) => CourseFolder::studentVisibleIdsForCourse((int) $courseId))
            ->unique()
            ->values();

        $materialsCount = CourseMaterial::whereIn('course_id', $enrolledIds)
            ->where('is_active', true)
            ->where(function ($q) use ($visibleFolderIds) {
                $q->whereNull('folder_id');
                if ($visibleFolderIds->isNotEmpty()) {
                    $q->orWhereIn('folder_id', $visibleFolderIds);
                }
            })
            ->count();

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
