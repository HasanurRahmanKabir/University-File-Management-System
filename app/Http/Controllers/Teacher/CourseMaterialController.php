<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseMaterial;
use App\Models\CourseFolder;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseMaterialController extends Controller
{
    public function index(Request $request)
    {
        $teacherDepartmentId = Auth::user()->department_id;
        $activeSemesterIds = \App\Models\Semester::running($teacherDepartmentId)->pluck('id')->toArray();

        $courses = Course::where('teacher_id', Auth::id())
            ->where('is_active', true)
            ->whereIn('semester_id', $activeSemesterIds)
            ->get();

        $courseIds = $courses->pluck('id');

        $query = CourseMaterial::with(['course', 'folder'])
            ->whereIn('course_id', $courseIds);

        if ($request->has('folder_id') && $request->folder_id != '') {
            $query->where('folder_id', $request->folder_id);
            $activeFolder = CourseFolder::find($request->folder_id);
        } else {
            $activeFolder = null;
        }

        $materials = $query->latest()->paginate(15)->appends($request->all());

        // Load folders grouped by course_id for the sidebar/dropdowns
        $folders = CourseFolder::whereIn('course_id', $courseIds)
            ->orderBy('name')
            ->get()
            ->groupBy('course_id');

        return view('teacher.uploadmaterials', compact('materials', 'courses', 'folders', 'activeFolder'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'folder_id' => 'nullable|exists:course_folders,id',
            'title'     => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'file'      => 'required|file|max:20480',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        if ($course->teacher_id !== Auth::id()) abort(403);

        // Validate folder belongs to the selected course
        if (!empty($validated['folder_id'])) {
            $folder = CourseFolder::findOrFail($validated['folder_id']);
            if ($folder->course_id !== (int) $validated['course_id']) {
                return back()->with('error', 'Invalid folder selected.');
            }
        }

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('course_materials', 'local');
            $validated['file_path'] = $path;
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
            $validated['file_size'] = $request->file('file')->getSize();
        }

        $validated['uploaded_by'] = Auth::id();
        $validated['folder_id']   = $validated['folder_id'] ?? null;

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
            'folder_id' => 'nullable|exists:course_folders,id',
            'title'     => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'file'      => 'nullable|file|max:20480',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        if ($course->teacher_id !== Auth::id()) abort(403);

        // Validate folder belongs to the selected course
        if (!empty($validated['folder_id'])) {
            $folder = CourseFolder::findOrFail($validated['folder_id']);
            if ($folder->course_id !== (int) $validated['course_id']) {
                return back()->with('error', 'Invalid folder selected.');
            }
        }

        if ($request->hasFile('file')) {
            if ($course_material->file_path && Storage::disk('local')->exists($course_material->file_path)) {
                Storage::disk('local')->delete($course_material->file_path);
            }
            $path = $request->file('file')->store('course_materials', 'local');
            $validated['file_path'] = $path;
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
            $validated['file_size'] = $request->file('file')->getSize();
        }

        $validated['folder_id'] = $validated['folder_id'] ?? null;
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

    public function preview(\App\Models\CourseMaterial $material)
    {
        if ($material->course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if (!$material->file_path || !\Illuminate\Support\Facades\Storage::disk('local')->exists($material->file_path)) {
            abort(404, 'File not found on the server.');
        }

        return response()->file(storage_path('app/' . $material->file_path));
    }
}