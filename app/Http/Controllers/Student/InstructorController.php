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

        $enrolledIds = $user->enrolledCourses()
            ->wherePivot('status', 'active')
            ->pluck('courses.id');

        $courses = Course::with('teacher')
            ->whereIn('id', $enrolledIds)
            ->where('is_active', true)
            ->whereNotNull('teacher_id')
            ->orderBy('course_code')
            ->get();

        // One card per instructor — all enrolled courses under that teacher
        $instructors = $courses
            ->groupBy('teacher_id')
            ->map(function ($teacherCourses) {
                $teacher = $teacherCourses->first()->teacher;
                if (!$teacher) {
                    return null;
                }

                return (object) [
                    'teacher' => $teacher,
                    'courses' => $teacherCourses->values(),
                ];
            })
            ->filter()
            ->sortBy(fn ($row) => strtolower($row->teacher->name ?? ''))
            ->values();

        return view('student.instructors.index', compact('instructors'));
    }
}
