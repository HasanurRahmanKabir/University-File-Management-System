<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseMaterial;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseMaterialController extends Controller
{
    public function index()
    {
        $materials = CourseMaterial::with(['course', 'uploader'])->latest()->paginate(15);
        $courses = Course::where('is_active', true)->get();
        return view('admin.course-files', compact('materials', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('course_materials', 'public');
            $validated['file_path'] = $path;
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
            $validated['file_size'] = $request->file('file')->getSize();
        }
        
        $validated['uploaded_by'] = auth()->id();

        CourseMaterial::create($validated);
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'uploaded_material',
            'description' => "Uploaded new material <strong>{$validated['title']}</strong>"
        ]);
        
        return back()->with('success', 'Material uploaded successfully.');
    }

    public function update(Request $request, CourseMaterial $courseMaterial)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('file')) {
            if ($courseMaterial->file_path && Storage::disk('public')->exists($courseMaterial->file_path)) {
                Storage::disk('public')->delete($courseMaterial->file_path);
            }
            $path = $request->file('file')->store('course_materials', 'public');
            $validated['file_path'] = $path;
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
            $validated['file_size'] = $request->file('file')->getSize();
        }

        $courseMaterial->update($validated);
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated_material',
            'description' => "Updated material <strong>{$validated['title']}</strong>"
        ]);
        
        return back()->with('success', 'Material updated successfully.');
    }

    public function destroy(CourseMaterial $courseMaterial)
    {
        $title = $courseMaterial->title;
        if ($courseMaterial->file_path && Storage::disk('public')->exists($courseMaterial->file_path)) {
            Storage::disk('public')->delete($courseMaterial->file_path);
        }
        $courseMaterial->delete();
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted_material',
            'description' => "Deleted material <strong>{$title}</strong>"
        ]);
        
        return back()->with('success', 'Material deleted successfully.');
    }
}