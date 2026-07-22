<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->has('search') && $request->search != '') {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
                  
                if (str_contains('active', $search)) {
                    $q->orWhere('is_active', true);
                } elseif (str_contains('inactive', $search)) {
                    $q->orWhere('is_active', false);
                }
            });
        }

        $categories = $query->latest()->paginate(10)->appends($request->all());
        return view('admin.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $slug = Str::slug($validated['name']);
        if (Category::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . substr(uniqid(), -4);
        }
        $validated['slug'] = $slug;
        $validated['is_active'] = $request->has('is_active');

        Category::create($validated);
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created_category',
            'description' => 'Created new category <strong>' . e($validated['name']) . '</strong>'
        ]);
        
        return back()->with('success', 'Category created successfully.');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($request->name !== $category->name) {
            $slug = Str::slug($validated['name']);
            if (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $slug . '-' . substr(uniqid(), -4);
            }
            $validated['slug'] = $slug;
        }
        $validated['is_active'] = $request->has('is_active');

        $category->update($validated);
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated_category',
            'description' => 'Updated category <strong>' . e($validated['name']) . '</strong>'
        ]);
        
        return back()->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $name = $category->name;

        if ($category->subcategories()->count() > 0) {
            return back()->with('error', 'Cannot delete category with assigned subcategories.');
        }

        if ($category->courses()->count() > 0) {
            return back()->with('error', 'Cannot delete category with assigned courses.');
        }

        $category->delete();
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted_category',
            'description' => 'Deleted category <strong>' . e($name) . '</strong>'
        ]);
        
        return back()->with('success', 'Category deleted successfully.');
    }
}