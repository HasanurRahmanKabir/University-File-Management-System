<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('faculty', 'like', "%{$search}%");
            });
        }

        $departments = $query->withCount(['users as teachers_count' => function($q) {
            $q->where('role', 'teacher');
        }])->latest()->paginate(15)->appends($request->all());
        
        return view('admin.departments', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'code' => 'required|string|max:20|unique:departments,code',
            'faculty' => 'nullable|string|max:255'
        ]);

        Department::create($validated);
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created_department',
            'description' => 'Created new department <strong>' . e($validated['name']) . '</strong>'
        ]);
        
        return back()->with('success', 'Department created successfully.');
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'code' => 'required|string|max:20|unique:departments,code,' . $department->id,
            'faculty' => 'nullable|string|max:255'
        ]);

        $department->update($validated);
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated_department',
            'description' => 'Updated department <strong>' . e($validated['name']) . '</strong>'
        ]);
        
        return back()->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $name = $department->name;
        
        if ($department->users()->count() > 0) {
            return back()->with('error', 'Cannot delete department with assigned users.');
        }

        if ($department->courses()->count() > 0) {
            return back()->with('error', 'Cannot delete department with assigned courses.');
        }
        
        $department->delete();
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted_department',
            'description' => 'Deleted department <strong>' . e($name) . '</strong>'
        ]);
        
        return back()->with('success', 'Department deleted successfully.');
    }
}
