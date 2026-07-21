<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->latest()->paginate(10);
        $categories = Category::where('is_active', true)->get();
        return view('admin.subcategory', compact('subcategories', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:subcategories',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        Subcategory::create($validated);
        return back()->with('success', 'Subcategory created successfully.');
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:subcategories,name,' . $subcategory->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($request->name !== $subcategory->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        $validated['is_active'] = $request->has('is_active');

        $subcategory->update($validated);
        return back()->with('success', 'Subcategory updated successfully.');
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return back()->with('success', 'Subcategory deleted successfully.');
    }
}