<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseFolder;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseFolderController extends Controller
{
    /**
     * Create a folder (root or nested). Admin folders are always student-visible.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'parent_id' => 'nullable|exists:course_folders,id',
            'name'      => 'required|string|max:100',
        ]);

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
            'is_active'  => true,
            'created_by' => Auth::id(),
        ]);

        $redirect = $parentId
            ? ['folder_id' => $parentId]
            : ['course_id' => $validated['course_id']];

        return redirect()
            ->route('admin.course-files.index', $redirect)
            ->with('success', 'Folder "' . $folder->name . '" created successfully.');
    }

    /**
     * Rename a folder (admin). Privacy is not managed on the admin side.
     */
    public function update(Request $request, CourseFolder $folder)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
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

        $folder->update(['name' => $name]);

        $redirect = $folder->parent_id
            ? ['folder_id' => $folder->parent_id]
            : ['course_id' => $folder->course_id];

        if ($request->boolean('stay_in_folder')) {
            $redirect = ['folder_id' => $folder->id];
        }

        return redirect()
            ->route('admin.course-files.index', $redirect)
            ->with('success', 'Folder updated successfully.');
    }

    /**
     * Delete any folder (admin privilege).
     */
    public function destroy(CourseFolder $folder)
    {
        $folderName = $folder->name;
        $courseId = $folder->course_id;
        $parentId = $folder->parent_id;
        $folder->delete();

        $redirect = $parentId
            ? ['folder_id' => $parentId]
            : ['course_id' => $courseId];

        return redirect()
            ->route('admin.course-files.index', $redirect)
            ->with('success', 'Folder "' . $folderName . '" deleted. Files moved to root.');
    }
}
