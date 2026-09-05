<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseMaterial;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseFileController extends Controller
{
    public function index(Request $request)
    {
        $query = CourseMaterial::with(['course', 'uploader']);
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('file_type', 'like', "%{$search}%")
                  ->orWhereHas('course', function($q) use ($search) {
                      $q->where('course_code', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%");
                  })
                  ->orWhereHas('uploader', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%");
                  });
            });
        }

        $materials = $query->latest()->paginate(15)->appends($request->all());
        $courses = Course::where('is_active', true)->get();
        
        // Dynamic Stats
        $totalFiles = CourseMaterial::count();
        $weeklyFiles = CourseMaterial::where('created_at', '>=', now()->subDays(7))->count();
        $pdfCount = CourseMaterial::where('file_type', 'like', 'pdf')->count();
        $pdfPercentage = $totalFiles > 0 ? round(($pdfCount / $totalFiles) * 100) : 0;
        
        $totalSizeBytes = CourseMaterial::sum('file_size');
        $totalSizeGB = round($totalSizeBytes / 1073741824, 2);
        if ($totalSizeGB < 0.1) {
            $totalSizeMB = round($totalSizeBytes / 1048576, 2);
            $storageUsed = $totalSizeMB . ' MB';
        } else {
            $storageUsed = $totalSizeGB . ' GB';
        }

        $teachers = User::where('role', 'teacher')->where('is_active', true)->get();

        return view('admin.course-files', compact('materials', 'courses', 'totalFiles', 'weeklyFiles', 'pdfCount', 'pdfPercentage', 'storageUsed', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'uploaded_by' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:20480', // Max 20MB limit
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('course_materials', 'local');
            $validated['file_path'] = $path;
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
            $validated['file_size'] = $request->file('file')->getSize();
        }
        
        $validated['uploaded_by'] = $request->uploaded_by ?? auth()->id();

        CourseMaterial::create($validated);
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'uploaded_material',
            'description' => 'Uploaded new material <strong>' . e($validated['title']) . '</strong>'
        ]);
        
        return back()->with('success', 'Material uploaded successfully.');
    }

    public function update(Request $request, CourseMaterial $courseMaterial)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'uploaded_by' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:20480', // Max 20MB limit
        ]);

        if ($request->hasFile('file')) {
            if ($courseMaterial->file_path && Storage::disk('local')->exists($courseMaterial->file_path)) {
                Storage::disk('local')->delete($courseMaterial->file_path);
            }
            $path = $request->file('file')->store('course_materials', 'local');
            $validated['file_path'] = $path;
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
            $validated['file_size'] = $request->file('file')->getSize();
        }

        $courseMaterial->update($validated);
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated_material',
            'description' => 'Updated material <strong>' . e($validated['title']) . '</strong>'
        ]);
        
        return back()->with('success', 'Material updated successfully.');
    }

    public function destroy(CourseMaterial $courseMaterial)
    {
        $title = $courseMaterial->title;
        if ($courseMaterial->file_path && Storage::disk('local')->exists($courseMaterial->file_path)) {
            Storage::disk('local')->delete($courseMaterial->file_path);
        }
        $courseMaterial->delete();
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted_material',
            'description' => 'Deleted material <strong>' . e($title) . '</strong>'
        ]);
        
        return back()->with('success', 'Material deleted successfully.');
    }

    public function download(\App\Models\CourseMaterial $material)
    {
        if (!$material->file_path || !\Illuminate\Support\Facades\Storage::disk('local')->exists($material->file_path)) {
            abort(404, 'File not found on the server.');
        }
        
        return response()->download(storage_path('app/' . $material->file_path));
    }

    public function preview(\App\Models\CourseMaterial $material)
    {
        if (!$material->file_path || !\Illuminate\Support\Facades\Storage::disk('local')->exists($material->file_path)) {
            abort(404, 'File not found on the server.');
        }
        
        return response()->file(storage_path('app/' . $material->file_path));
    }
}