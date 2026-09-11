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
     * Create a new folder in any course (admin privilege).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name'      => 'required|string|max:100',
        ]);

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
     * Delete any folder (admin privilege).
     */
    public function destroy(CourseFolder $folder)
    {
        $folderName = $folder->name;
        $folder->delete();

        return back()->with('success', 'Folder "' . $folderName . '" deleted. Files moved to root.');
    }
}
