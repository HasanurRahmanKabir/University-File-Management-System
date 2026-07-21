<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;

class CourseMaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = CourseMaterial::with(['course.teacher']);
        
        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }
        
        $materials = $query->latest()->paginate(15);
        return view('student.course-file', compact('materials'));
    }
    
    public function download(CourseMaterial $material)
    {
        if (!$material->file_path) {
            abort(404);
        }
        return response()->download(storage_path('app/public/' . $material->file_path));
    }
}