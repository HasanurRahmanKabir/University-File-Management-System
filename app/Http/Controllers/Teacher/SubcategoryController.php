<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubcategoryController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();
        
        $subcategories = Subcategory::whereHas('courses', function($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId)->where('is_active', true);
        })->with(['department', 'courses' => function($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId)->where('is_active', true);
        }])->latest()->paginate(15);
        
        return view('teacher.subcategorylist', compact('subcategories'));
    }
}
