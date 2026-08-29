<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();
        
        $categories = Category::whereHas('courses', function($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId)->where('is_active', true);
        })->with(['courses' => function($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId)->where('is_active', true);
        }])->latest()->paginate(15);
        
        return view('teacher.categorylist', compact('categories'));
    }
}
