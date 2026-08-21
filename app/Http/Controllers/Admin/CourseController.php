<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with(['department', 'category', 'subcategory']);
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%")
                  ->orWhere('course_code', 'like', "%{$search}%")
                  ->orWhereHas('department', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
                  
                if (strtolower($search) === 'active') {
                    $q->orWhere('is_active', 1);
                } elseif (strtolower($search) === 'inactive') {
                    $q->orWhere('is_active', 0);
                }
            });
        }

        $courses = $query->latest()->paginate(10)->appends($request->all());
        $departments = Department::all();
        $categories = \App\Models\Category::where('is_active', true)->get();
        $subcategories = \App\Models\Subcategory::where('is_active', true)->get();
        
        return view('admin.courses', compact('courses', 'departments', 'categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'nullable|exists:users,id',
            'department_id' => 'nullable|exists:departments,id',
            'course_type' => 'nullable|in:category,subcategory',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'course_code' => ['required', 'string', 'max:50', Rule::unique('courses')->whereNull('deleted_at')],
            'credit' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);

        // Generate a universally unique slug even accounting for soft deletes
        $baseSlug = Str::slug($validated['title'] . '-' . $validated['course_code']);
        $slug = $baseSlug;
        $counter = 1;
        while (\App\Models\Course::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;
        
        $validated['is_active'] = $request->has('is_active') ? $request->is_active : true;

        if (isset($validated['course_type'])) {
            if ($validated['course_type'] === 'category') {
                $validated['subcategory_id'] = null;
            } elseif ($validated['course_type'] === 'subcategory') {
                $validated['category_id'] = null;
            }
            unset($validated['course_type']);
        }

        Course::create($validated);
        return back()->with('success', 'Course created successfully.');
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'teacher_id' => 'nullable|exists:users,id',
            'department_id' => 'nullable|exists:departments,id',
            'course_type' => 'nullable|in:category,subcategory',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'course_code' => ['required', 'string', 'max:50', Rule::unique('courses')->ignore($course->id)->whereNull('deleted_at')],
            'credit' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);

        // Regenerate unique slug if title or code changed
        if ($request->title !== $course->title || $request->course_code !== $course->course_code) {
            $baseSlug = Str::slug($validated['title'] . '-' . $validated['course_code']);
            $slug = $baseSlug;
            $counter = 1;
            while (\App\Models\Course::withTrashed()->where('slug', $slug)->where('id', '!=', $course->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
        }
        $validated['is_active'] = $request->has('is_active') ? $request->is_active : $course->is_active;

        if ($request->has('course_type')) {
            if ($request->course_type === 'category') {
                $validated['subcategory_id'] = null;
            } elseif ($request->course_type === 'subcategory') {
                $validated['category_id'] = null;
            }
            unset($validated['course_type']);
        } else {
            // If they didn't submit course_type, keep existing values or null them out depending on how form is submitted
            $validated['category_id'] = null;
            $validated['subcategory_id'] = null;
        }

        $course->update($validated);
        return back()->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return back()->with('success', 'Course deleted successfully.');
    }
}