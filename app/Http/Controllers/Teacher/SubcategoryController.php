<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with(['department', 'courses'])->latest()->paginate(15);
        return view('teacher.subcategorylist', compact('subcategories'));
    }
}
