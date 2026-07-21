<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['category', 'subcategory', 'teacher'])->latest()->paginate(10);
        $categories = Category::where('is_active', true)->get();
        $subcategories = Subcategory::where('is_active', true)->get();
        $teachers = User::where('role', 'teacher')->where('is_active', true)->get();
        return view('admin.course', compact('courses', 'categories', 'subcategories', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'nullable|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses',
            'description' => 'nullable|string',
            'year' => 'nullable|string|max:4',
            'semester' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');

        Course::create($validated);
        return back()->with('success', 'Course created successfully.');
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'teacher_id' => 'nullable|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code,' . $course->id,
            'description' => 'nullable|string',
            'year' => 'nullable|string|max:4',
            'semester' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ]);

        if ($request->title !== $course->title) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        $validated['is_active'] = $request->has('is_active');

        $course->update($validated);
        return back()->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return back()->with('success', 'Course deleted successfully.');
    }
}