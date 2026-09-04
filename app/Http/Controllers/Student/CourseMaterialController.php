<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;

class CourseMaterialController extends Controller
{
    public function index(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        $enrolledIds = is_array($user->enrolled_courses) ? $user->enrolled_courses : [];
        if (!is_array($enrolledIds)) {
            $enrolledIds = [];
        }

        $courses = \App\Models\Course::with(['materials' => function($q) {
            $q->where('is_active', true)->latest();
        }])
        ->whereIn('id', $enrolledIds)
        ->where('is_active', true)
        ->latest()
        ->paginate(10);
        
        return view('student.course-materials.index', compact('courses'));
    }
    
    public function download(CourseMaterial $material)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        $enrolledIds = is_array($user->enrolled_courses) ? $user->enrolled_courses : [];
        if (!is_array($enrolledIds)) {
            $enrolledIds = [];
        }

        // Security Check: Prevent IDOR (Insecure Direct Object Reference)
        if (!in_array($material->course_id, $enrolledIds)) {
            abort(403, 'Unauthorized access. You are not enrolled in this course.');
        }

        if (!$material->file_path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($material->file_path)) {
            abort(404, 'File not found on the server.');
        }
        
        return response()->download(storage_path('app/public/' . $material->file_path));
    }
}