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
        $teacherDepartmentId = Auth::user()->department_id;
        $activeSemesterIds = \App\Models\Semester::running($teacherDepartmentId)->pluck('id')->toArray();
        $courses = Course::where('teacher_id', Auth::id())
            ->where('is_active', true)
            ->whereIn('semester_id', $activeSemesterIds)
            ->get();
        $materials = CourseMaterial::with('course')->whereIn('course_id', $courses->pluck('id'))->latest()->paginate(15);
        return view('teacher.uploadmaterials', compact('materials', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'file' => 'required|file|max:20480',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        if ($course->teacher_id !== Auth::id()) abort(403);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('course_materials', 'local');
            $validated['file_path'] = $path;
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
            $validated['file_size'] = $request->file('file')->getSize();
        }

        $validated['uploaded_by'] = Auth::id();

        CourseMaterial::create($validated);
        return back()->with('success', 'Material uploaded successfully.');
    }

    public function destroy(CourseMaterial $course_material)
    {
        if ($course_material->course->teacher_id !== Auth::id()) abort(403);
        
        if ($course_material->file_path && Storage::disk('local')->exists($course_material->file_path)) {
            Storage::disk('local')->delete($course_material->file_path);
        }
        $course_material->delete();
        return back()->with('success', 'Material deleted successfully.');
    }

    public function update(Request $request, CourseMaterial $course_material)
    {
        if ($course_material->course->teacher_id !== Auth::id()) abort(403);
        
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'file' => 'nullable|file|max:20480',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        if ($course->teacher_id !== Auth::id()) abort(403);

        if ($request->hasFile('file')) {
            // Delete old file
            if ($course_material->file_path && Storage::disk('local')->exists($course_material->file_path)) {
                Storage::disk('local')->delete($course_material->file_path);
            }
            
            // Store new file
            $path = $request->file('file')->store('course_materials', 'local');
            $validated['file_path'] = $path;
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
            $validated['file_size'] = $request->file('file')->getSize();
        }

        $course_material->update($validated);
        return back()->with('success', 'Material updated successfully.');
    }

    public function download(\App\Models\CourseMaterial $material)
    {
        if ($material->course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if (!$material->file_path || !\Illuminate\Support\Facades\Storage::disk('local')->exists($material->file_path)) {
            abort(404, 'File not found on the server.');
        }
        
        return response()->download(storage_path('app/' . $material->file_path));
    }
}