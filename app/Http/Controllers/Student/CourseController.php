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
        $studentDepartmentId = $user->department_id;
        
        // Get enrolled course IDs
        $enrolledIds = $user->enrolledCourses()->pluck('courses.id')->toArray();
        
        $activeSemesterIds = \App\Models\Semester::running($studentDepartmentId)->pluck('id')->toArray();
        $activeSemester = \App\Models\Semester::running($studentDepartmentId)->first();

        $runningCoursesQuery = Course::with(['category', 'subcategory', 'teacher', 'semester'])
            ->whereIn('id', $enrolledIds)
            ->where('is_active', true);
            
        $previousCoursesQuery = Course::with(['category', 'subcategory', 'teacher', 'semester'])
            ->whereIn('id', $enrolledIds)
            ->where('is_active', true);

        if (!empty($activeSemesterIds)) {
            $runningCoursesQuery->whereIn('semester_id', $activeSemesterIds);
            $previousCoursesQuery->where(function($q) use ($activeSemesterIds) {
                $q->whereNotIn('semester_id', $activeSemesterIds)
                  ->orWhereNull('semester_id');
            });
        } else {
            $previousCoursesQuery->whereNotNull('id');
            $runningCoursesQuery->whereNull('id');
        }

        $runningCourses = $runningCoursesQuery->latest()->get();
        $previousCourses = $previousCoursesQuery->latest()->get();

        $previousCourses = $previousCourses->sortByDesc(function($course) {
            return $course->semester ? ($course->semester->start_date ?? $course->semester->created_at) : '0000-00-00';
        });

        $groupedPreviousCourses = $previousCourses->groupBy(function($course) {
            return $course->semester ? $course->semester->name . ' ' . ($course->semester->year ?? '') : 'Unassigned Semester';
        });

        return view('student.courses.index', compact('runningCourses', 'groupedPreviousCourses', 'activeSemester'));
    }
}