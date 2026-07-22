<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Subcategory::with('category');

        if ($request->has('search') && $request->search != '') {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
                  
                if (str_contains('active', $search)) {
                    $q->orWhere('is_active', true);
                } elseif (str_contains('inactive', $search)) {
                    $q->orWhere('is_active', false);
                }
            });
        }

        $subcategories = $query->latest()->paginate(10)->appends($request->all());
        $categories = Category::where('is_active', true)->get();
        return view('admin.subcategories', compact('subcategories', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:subcategories',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $slug = Str::slug($validated['name']);
        if (Subcategory::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . substr(uniqid(), -4);
        }
        $validated['slug'] = $slug;
        $validated['is_active'] = $request->has('is_active');

        Subcategory::create($validated);
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created_subcategory',
            'description' => 'Created new subcategory <strong>' . e($validated['name']) . '</strong>'
        ]);
        
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
            $slug = Str::slug($validated['name']);
            if (Subcategory::where('slug', $slug)->where('id', '!=', $subcategory->id)->exists()) {
                $slug = $slug . '-' . substr(uniqid(), -4);
            }
            $validated['slug'] = $slug;
        }
        $validated['is_active'] = $request->has('is_active');

        $subcategory->update($validated);
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated_subcategory',
            'description' => 'Updated subcategory <strong>' . e($validated['name']) . '</strong>'
        ]);
        
        return back()->with('success', 'Subcategory updated successfully.');
    }

    public function destroy(Subcategory $subcategory)
    {
        $name = $subcategory->name;
        
        if ($subcategory->courses()->count() > 0) {
            return back()->with('error', 'Cannot delete subcategory with assigned courses.');
        }

        $subcategory->delete();
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted_subcategory',
            'description' => 'Deleted subcategory <strong>' . e($name) . '</strong>'
        ]);
        
        return back()->with('success', 'Subcategory deleted successfully.');
    }
}