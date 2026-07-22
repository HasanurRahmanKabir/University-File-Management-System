<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

use App\Models\Department;
use App\Models\Course;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['department', 'courses'])->where('role', 'teacher');
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%")
                  ->orWhereHas('department', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $users = $query->latest()->paginate(15)->appends($request->all());
        $departments = Department::orderBy('name')->get();
        $courses = Course::orderBy('course_code')->get();
        
        return view('admin.teachers', compact('users', 'departments', 'courses'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Password::defaults()],
            'department_id' => 'nullable|exists:departments,id',
            'designation' => 'nullable|string|max:100',
            'is_active' => 'required|boolean',
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id'
        ]);
        
        $validated['role'] = 'teacher';
        $validated['password'] = Hash::make($validated['password']);

        $teacher = User::create($validated);
        
        if ($request->has('courses')) {
            Course::whereIn('id', $request->courses)->update(['teacher_id' => $teacher->id]);
        }

        return back()->with('success', 'Teacher registered successfully.');
    }

    public function update(Request $request, $id)
    {
        $teacher = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $teacher->id,
            'department_id' => 'nullable|exists:departments,id',
            'designation' => 'nullable|string|max:100',
            'is_active' => 'required|boolean',
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id'
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => ['required', Password::defaults()]]);
            $validated['password'] = Hash::make($request->password);
        }

        $teacher->update($validated);
        
        // Remove old courses
        Course::where('teacher_id', $teacher->id)->update(['teacher_id' => null]);
        
        // Assign new courses
        if ($request->has('courses')) {
            Course::whereIn('id', $request->courses)->update(['teacher_id' => $teacher->id]);
        }

        return back()->with('success', 'Teacher updated successfully.');
    }

    public function destroy($id)
    {
        $teacher = User::findOrFail($id);
        // Remove assigned courses before deleting
        Course::where('teacher_id', $teacher->id)->update(['teacher_id' => null]);
        $teacher->delete();
        return back()->with('success', 'Teacher deleted successfully.');
    }
}
