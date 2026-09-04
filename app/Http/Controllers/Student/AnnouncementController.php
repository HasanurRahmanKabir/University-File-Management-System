<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CourseAnnouncement;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $student = Auth::user();
        $enrolledCourseIds = $student->enrolledCourses()->pluck('courses.id')->toArray();

        $announcements = CourseAnnouncement::with(['course', 'teacher'])
            ->whereIn('course_id', $enrolledCourseIds)
            ->latest()
            ->paginate(12);

        return view('student.announcements.index', compact('announcements'));
    }
}
