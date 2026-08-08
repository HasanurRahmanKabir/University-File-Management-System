<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $enrolledIds = $user->enrolled_courses ? json_decode($user->enrolled_courses, true) : [];
        if (!is_array($enrolledIds)) {
            $enrolledIds = [];
        }

        // Fetch categories that have at least one course the student is enrolled in
        $categories = Category::whereHas('courses', function($q) use ($enrolledIds) {
            $q->whereIn('id', $enrolledIds)->where('is_active', true);
        })->with(['courses' => function($q) use ($enrolledIds) {
            $q->whereIn('id', $enrolledIds)->where('is_active', true)->with('subcategory');
        }])
        ->where('is_active', true)
        ->latest()
        ->paginate(10);
        
        return view('student.subcategories.index', compact('categories'));
    }
}
