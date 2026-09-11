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
     * Create a new folder for a teacher's own course.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name'      => 'required|string|max:100',
        ]);

        // Security: teacher can only create folders in their own courses
        $course = Course::findOrFail($validated['course_id']);
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'You are not authorized to create folders in this course.');
        }

        // Prevent duplicate folder names in same course
        $exists = CourseFolder::where('course_id', $validated['course_id'])
            ->where('parent_id', null)
            ->whereRaw('LOWER(name) = ?', [strtolower(trim($validated['name']))])
            ->exists();

        if ($exists) {
            return back()->with('error', 'A folder with this name already exists in this course.');
        }

        CourseFolder::create([
            'course_id'  => $validated['course_id'],
            'parent_id'  => null,
            'name'       => trim($validated['name']),
            'created_by' => Auth::id(),
        ]);

        return back()->with('success', 'Folder "' . trim($validated['name']) . '" created successfully.');
    }

    /**
     * Delete a folder (and all its files will be detached via SET NULL on cascade).
     */
    public function destroy(CourseFolder $folder)
    {
        // Security: teacher can only delete folders they own or in their course
        if ($folder->course->teacher_id !== Auth::id()) {
            abort(403, 'You are not authorized to delete this folder.');
        }

        $folderName = $folder->name;
        $folder->delete();

        return back()->with('success', 'Folder "' . $folderName . '" deleted. Files moved to root.');
    }
}
