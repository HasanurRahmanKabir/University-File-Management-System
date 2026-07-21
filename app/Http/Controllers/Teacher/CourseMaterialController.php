<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseMaterial;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseMaterialController extends Controller
{
    public function index()
    {
        $courses = Course::where('teacher_id', Auth::id())->where('is_active', true)->get();
        $materials = CourseMaterial::with('course')->whereIn('course_id', $courses->pluck('id'))->latest()->paginate(15);
        return view('teacher.upload-materials', compact('materials', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        if ($course->teacher_id !== Auth::id()) abort(403);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('course_materials', 'public');
            $validated['file_path'] = $path;
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
        }

        CourseMaterial::create($validated);
        return back()->with('success', 'Material uploaded successfully.');
    }

    public function destroy(CourseMaterial $course_material)
    {
        if ($course_material->course->teacher_id !== Auth::id()) abort(403);
        
        if ($course_material->file_path && Storage::disk('public')->exists($course_material->file_path)) {
            Storage::disk('public')->delete($course_material->file_path);
        }
        $course_material->delete();
        return back()->with('success', 'Material deleted successfully.');
    }
}