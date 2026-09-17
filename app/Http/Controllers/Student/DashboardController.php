<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseAnnouncement;
use App\Models\CourseFolder;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $enrolledIds = $user->enrolledCourses()
            ->wherePivot('status', 'active')
            ->pluck('courses.id')
            ->toArray();

        $myCourses = Course::with(['teacher', 'semester'])
            ->whereIn('id', $enrolledIds)
            ->where('is_active', true)
            ->get();

        $activeCourseIds = $myCourses->pluck('id')->all();

        // Count only student-visible materials (file Only Me + private folder trees stay hidden)
        $visibleFolderIds = collect($activeCourseIds)
            ->flatMap(fn ($courseId) => CourseFolder::studentVisibleIdsForCourse((int) $courseId))
            ->unique()
            ->values();

        $materialsCount = CourseMaterial::whereIn('course_id', $activeCourseIds)
            ->where('is_active', true)
            ->where(function ($q) use ($visibleFolderIds) {
                $q->whereNull('folder_id');
                if ($visibleFolderIds->isNotEmpty()) {
                    $q->orWhereIn('folder_id', $visibleFolderIds);
                }
            })
            ->count();

        $noticesCount = empty($activeCourseIds)
            ? 0
            : CourseAnnouncement::whereIn('course_id', $activeCourseIds)->count();

        $stats = [
            'courses' => $myCourses->count(),
            'materials' => $materialsCount,
            'notices' => $noticesCount,
        ];

        $recentCourses = $myCourses->take(5);

        return view('student.dashboard', compact('stats', 'recentCourses'));
    }
}
