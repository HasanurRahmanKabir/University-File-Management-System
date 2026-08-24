<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            'courses.*' => 'exists:courses,id',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);
        
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('teachers', 'public');
            $validated['profile_image'] = $path;
        }
        
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
            'courses.*' => 'exists:courses,id',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->has('remove_image') && $request->remove_image == '1') {
            if ($teacher->profile_image && Storage::disk('public')->exists($teacher->profile_image)) {
                Storage::disk('public')->delete($teacher->profile_image);
            }
            $validated['profile_image'] = null;
        }

        if ($request->hasFile('profile_image')) {
            if ($teacher->profile_image && Storage::disk('public')->exists($teacher->profile_image)) {
                Storage::disk('public')->delete($teacher->profile_image);
            }
            $path = $request->file('profile_image')->store('teachers', 'public');
            $validated['profile_image'] = $path;
        }

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
        if ($teacher->profile_image && Storage::disk('public')->exists($teacher->profile_image)) {
            Storage::disk('public')->delete($teacher->profile_image);
        }
        // Remove assigned courses before deleting
        Course::where('teacher_id', $teacher->id)->update(['teacher_id' => null]);
        $teacher->delete();
        return back()->with('success', 'Teacher deleted successfully.');
    }
}
