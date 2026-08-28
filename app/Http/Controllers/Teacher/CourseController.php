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
        $teacherId = Auth::id();
        $allStudents = \App\Models\User::where('role', 'student')->get();

        $activeSemesterIds = \App\Models\Semester::running()->pluck('id')->toArray();
        
        $runningCoursesQuery = Course::with(['category', 'subcategory'])->where('teacher_id', $teacherId);
        $previousCoursesQuery = Course::with(['category', 'subcategory'])->where('teacher_id', $teacherId);
        
        if (!empty($activeSemesterIds)) {
            $runningCoursesQuery->whereIn('semester_id', $activeSemesterIds);
            $previousCoursesQuery->where(function($q) use ($activeSemesterIds) {
                $q->whereNotIn('semester_id', $activeSemesterIds)
                  ->orWhereNull('semester_id');
            });
        } else {
            // Fallback if no active semester exists
            $previousCoursesQuery->whereNotNull('id'); // Select all as previous
            $runningCoursesQuery->whereNull('id'); // Empty running
        }

        $runningCourses = $runningCoursesQuery->latest()->get()->map(function($course) use ($allStudents) {
            $course->enrolled_students = $allStudents->filter(function ($student) use ($course) {
                $enrolled = is_string($student->enrolled_courses) ? json_decode($student->enrolled_courses, true) : $student->enrolled_courses;
                return is_array($enrolled) && in_array($course->id, $enrolled);
            })->count();
            return $course;
        });

        $previousCourses = $previousCoursesQuery->latest()->get()->map(function($course) use ($allStudents) {
            $course->enrolled_students = $allStudents->filter(function ($student) use ($course) {
                $enrolled = is_string($student->enrolled_courses) ? json_decode($student->enrolled_courses, true) : $student->enrolled_courses;
                return is_array($enrolled) && in_array($course->id, $enrolled);
            })->count();
            return $course;
        });

        $activeCoursesCount = $runningCourses->count();
        
        $teacherCourseIds = Course::where('teacher_id', $teacherId)->pluck('id')->toArray();
        $totalStudents = $allStudents->filter(function ($student) use ($teacherCourseIds) {
            $enrolled = is_string($student->enrolled_courses) ? json_decode($student->enrolled_courses, true) : $student->enrolled_courses;
            if (!is_array($enrolled)) return false;
            return count(array_intersect($enrolled, $teacherCourseIds)) > 0;
        })->count();

        $departments = \App\Models\Department::all();
        $categories = \App\Models\Category::where('is_active', true)->get();
        $subcategories = \App\Models\Subcategory::where('is_active', true)->get();
        $semesters = \App\Models\Semester::running()->get();

        $activeSemester = \App\Models\Semester::running()->first();

        $teacherDepartmentId = Auth::user()->department_id;

        return view('teacher.mycourseinfo', compact('runningCourses', 'previousCourses', 'activeCoursesCount', 'totalStudents', 'departments', 'categories', 'subcategories', 'semesters', 'activeSemester', 'teacherDepartmentId'));
    }

    public function show(Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }
        $course->load('materials');
        return view('teacher.course-detail', compact('course'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'nullable|exists:departments,id',
            'course_type' => 'nullable|in:category,subcategory',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'course_code' => ['required', 'string', 'max:50', \Illuminate\Validation\Rule::unique('courses')->whereNull('deleted_at')],
            'credit' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
            'semester_id' => 'required|exists:semesters,id'
        ]);

        $baseSlug = \Illuminate\Support\Str::slug($validated['title'] . '-' . $validated['course_code']);
        $slug = $baseSlug;
        $counter = 1;
        while (\App\Models\Course::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;
        
        $validated['is_active'] = $request->has('is_active') ? $request->is_active : true;
        $validated['teacher_id'] = Auth::id(); // Assign to current teacher
        $validated['created_by'] = Auth::id(); // Record who created it

        if (isset($validated['course_type'])) {
            if ($validated['course_type'] === 'category') {
                $validated['subcategory_id'] = null;
            } elseif ($validated['course_type'] === 'subcategory') {
                $validated['category_id'] = null;
            }
            unset($validated['course_type']);
        }

        $course = Course::create($validated);
        
        // Notify Admins
        $admins = \App\Models\User::where('role', 'admin')->orWhere('role', 'super_admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\GlobalActivityNotification(
            'New Course Added',
            'Teacher ' . Auth::user()->name . ' has added a new course: ' . $course->title . ' (' . $course->course_code . ')',
            route('admin.courses.index'),
            'fas fa-book-open',
            'var(--primary)'
        ));

        return back()->with('success', 'Course created successfully.');
    }

    public function update(Request $request, Course $course)
    {
        if ($course->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action. You can only edit courses you created.');
        }

        $validated = $request->validate([
            'department_id' => 'nullable|exists:departments,id',
            'course_type' => 'nullable|in:category,subcategory',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'course_code' => ['required', 'string', 'max:50', \Illuminate\Validation\Rule::unique('courses')->ignore($course->id)->whereNull('deleted_at')],
            'credit' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
            'semester_id' => 'required|exists:semesters,id'
        ]);

        $baseSlug = \Illuminate\Support\Str::slug($validated['title'] . '-' . $validated['course_code']);
        $slug = $baseSlug;
        $counter = 1;
        while (\App\Models\Course::withTrashed()->where('slug', $slug)->where('id', '!=', $course->id)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;

        $validated['is_active'] = $request->has('is_active') ? $request->is_active : false;

        if (isset($validated['course_type'])) {
            if ($validated['course_type'] === 'category') {
                $validated['subcategory_id'] = null;
            } elseif ($validated['course_type'] === 'subcategory') {
                $validated['category_id'] = null;
            }
            unset($validated['course_type']);
        }

        $course->update($validated);
        return back()->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        if ($course->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action. You can only delete courses you created.');
        }
        
        $course->delete();
        return back()->with('success', 'Course deleted successfully.');
    }
}