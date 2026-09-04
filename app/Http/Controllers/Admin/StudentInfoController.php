<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class StudentInfoController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentInfo::with('department')->where('role', 'student');
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            
            $matchingCourseIds = \App\Models\Course::where('course_code', 'like', "%{$search}%")
                                    ->orWhere('title', 'like', "%{$search}%")
                                    ->pluck('id')
                                    ->toArray();

            $query->where(function($q) use ($search, $matchingCourseIds) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('semester', 'like', "%{$search}%");
                  
                // Status search
                if (strtolower($search) === 'active') {
                    $q->orWhere('is_active', 1);
                } elseif (strtolower($search) === 'inactive') {
                    $q->orWhere('is_active', 0);
                }
                  
                if (!empty($matchingCourseIds)) {
                    $q->orWhereHas('enrolledCourses', function($q2) use ($matchingCourseIds) {
                        $q2->whereIn('courses.id', $matchingCourseIds);
                    });
                }
            });
        }
        
        $users = $query->latest()->paginate(15);
        $users->appends(['search' => $request->search]);
        
        $courses = \App\Models\Course::where('is_active', true)->orderBy('course_code')->get();
        $semesters = \App\Models\Semester::where('is_active', true)->latest()->get();
        $departments = \App\Models\Department::orderBy('name')->get();
        
        $totalStudents = StudentInfo::where('role', 'student')->count();
        $activeStudents = StudentInfo::where('role', 'student')->where('is_active', 1)->count();
        $inactiveStudents = StudentInfo::where('role', 'student')->where('is_active', 0)->count();

        return view('admin.students', compact('users', 'courses', 'semesters', 'departments', 'totalStudents', 'activeStudents', 'inactiveStudents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:255|unique:users',
            'semester' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'department_id' => 'nullable|exists:departments,id',
            'password' => ['required', Password::defaults()],
            'courses' => 'nullable|array',
            'is_active' => 'nullable|boolean',
            'contact_number' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);
        
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('students', 'public');
            $validated['profile_image'] = $path;
        }

        $validated['role'] = 'student';
        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->boolean('is_active') ? 1 : 0;

        if (isset($validated['courses'])) {
            $courses = $validated['courses'];
            unset($validated['courses']);
        }

        $student = StudentInfo::create($validated);
        
        if (isset($courses) && is_array($courses)) {
            $student->enrolledCourses()->sync($courses);
        }
        
        return back()->with('success', 'Student Created Successfully.');
    }

    public function update(Request $request, $id)
    {
        $user = StudentInfo::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:255|unique:users,student_id,' . $user->id,
            'semester' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'department_id' => 'nullable|exists:departments,id',
            'password' => 'nullable|string|min:8',
            'courses' => 'nullable|array',
            'is_active' => 'nullable|boolean',
            'contact_number' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'remove_image' => 'nullable|boolean'
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        if (isset($validated['courses'])) {
            $courses = $validated['courses'];
            unset($validated['courses']);
        } else {
            $courses = [];
        }

        if ($request->has('remove_image') && $request->remove_image == 1) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $validated['profile_image'] = null;
        } elseif ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $path = $request->file('profile_image')->store('students', 'public');
            $validated['profile_image'] = $path;
        }

        $validated['is_active'] = $request->boolean('is_active') ? 1 : 0;

        $user->update($validated);
        
        if (isset($courses)) {
            $user->enrolledCourses()->sync($courses);
        }

        return back()->with('success', 'Student Updated Successfully.');
    }

    public function destroy($id)
    {
        $user = StudentInfo::findOrFail($id);
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }
        $user->delete();
        return back()->with('success', 'Student Deleted Successfully.');
    }
}
