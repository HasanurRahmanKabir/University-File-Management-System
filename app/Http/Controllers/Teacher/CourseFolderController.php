<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseFolder;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseFolderController extends Controller
{
    /**
     * Create a folder (root or nested under parent_id).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'parent_id' => 'nullable|exists:course_folders,id',
            'name'      => 'required|string|max:100',
            'is_active' => 'required|boolean',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'You are not authorized to create folders in this course.');
        }

        $parentId = $validated['parent_id'] ?? null;
        if ($parentId) {
            $parent = CourseFolder::findOrFail($parentId);
            if ((int) $parent->course_id !== (int) $validated['course_id']) {
                return back()->with('error', 'Parent folder does not belong to this course.');
            }
        }

        $exists = CourseFolder::where('course_id', $validated['course_id'])
            ->where('parent_id', $parentId)
            ->whereRaw('LOWER(name) = ?', [strtolower(trim($validated['name']))])
            ->exists();

        if ($exists) {
            return back()->with('error', 'A folder with this name already exists here.');
        }

        $folder = CourseFolder::create([
            'course_id'  => $validated['course_id'],
            'parent_id'  => $parentId,
            'name'       => trim($validated['name']),
            'is_active'  => (bool) $validated['is_active'],
            'created_by' => Auth::id(),
        ]);

        $redirect = $parentId
            ? ['folder_id' => $parentId]
            : ['course_id' => $validated['course_id']];

        return redirect()
            ->route('teacher.course-materials.index', $redirect)
            ->with('success', 'Folder "' . $folder->name . '" created successfully.');
    }

    /**
     * Rename / update privacy for a folder.
     */
    public function update(Request $request, CourseFolder $folder)
    {
        if ($folder->course->teacher_id !== Auth::id()) {
            abort(403, 'You are not authorized to update this folder.');
        }

        $validated = $request->validate([
            'name'      => 'required|string|max:100',
            'is_active' => 'required|boolean',
        ]);

        $name = trim($validated['name']);
        $exists = CourseFolder::where('course_id', $folder->course_id)
            ->where('parent_id', $folder->parent_id)
            ->where('id', '!=', $folder->id)
            ->whereRaw('LOWER(name) = ?', [strtolower($name)])
            ->exists();

        if ($exists) {
            return back()->with('error', 'A folder with this name already exists here.');
        }

        $folder->update([
            'name'      => $name,
            'is_active' => (bool) $validated['is_active'],
        ]);

        if ($request->boolean('stay_in_folder')) {
            $redirect = ['folder_id' => $folder->id];
        } else {
            $redirect = $folder->parent_id
                ? ['folder_id' => $folder->parent_id]
                : ['course_id' => $folder->course_id];
        }

        return redirect()
            ->route('teacher.course-materials.index', $redirect)
            ->with('success', 'Folder updated successfully.');
    }

    /**
     * Delete a folder (children cascade via FK; files detach via SET NULL).
     */
    public function destroy(CourseFolder $folder)
    {
        if ($folder->course->teacher_id !== Auth::id()) {
            abort(403, 'You are not authorized to delete this folder.');
        }

        $folderName = $folder->name;
        $courseId = $folder->course_id;
        $parentId = $folder->parent_id;
        $folder->delete();

        $redirect = $parentId
            ? ['folder_id' => $parentId]
            : ['course_id' => $courseId];

        return redirect()
            ->route('teacher.course-materials.index', $redirect)
            ->with('success', 'Folder "' . $folderName . '" deleted. Files moved to root.');
    }
}
