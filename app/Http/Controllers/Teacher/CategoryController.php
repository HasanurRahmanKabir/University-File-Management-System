<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('subcategories')->latest()->paginate(15);
        return view('teacher.categorylist', compact('categories'));
    }
}
