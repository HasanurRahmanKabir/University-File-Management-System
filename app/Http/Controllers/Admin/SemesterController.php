<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index(Request $request)
    {
        $query = Semester::with('departments');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('year', 'like', "%{$search}%");

                if (strtolower(trim($search)) === 'active') {
                    $q->orWhere('is_active', true);
                } elseif (strtolower(trim($search)) === 'inactive') {
                    $q->orWhere('is_active', false);
                }
            });
        }

        $semesters = $query->latest()->paginate(15)->appends($request->all());
        $departments = \App\Models\Department::all();
        return view('admin.semesters', compact('semesters', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_ids' => 'required|array',
            'department_ids.*' => 'exists:departments,id',
            'year' => 'nullable|integer|min:2000|max:2100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    $start = $request->start_date;
                    $end = $request->end_date;

                    $exists = Semester::where('name', $value)
                        ->where('start_date', $start)
                        ->where('end_date', $end)
                        ->exists();

                    if ($exists) {
                        $fail("A semester with this exact name, start date, and end date already exists. You cannot create duplicate terms with the same exact timeframe.");
                    }
                }
            ],
        ]);

        $semester = Semester::create($validated);
        $semester->departments()->attach($request->department_ids);
        
        return back()->with('success', 'Semester created successfully.');
    }

    public function update(Request $request, $id)
    {
        $semester = Semester::findOrFail($id);
        $validated = $request->validate([
            'department_ids' => 'required|array',
            'department_ids.*' => 'exists:departments,id',
            'year' => 'nullable|integer|min:2000|max:2100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request, $id) {
                    $start = $request->start_date;
                    $end = $request->end_date;

                    $exists = Semester::where('name', $value)
                        ->where('start_date', $start)
                        ->where('end_date', $end)
                        ->where('id', '!=', $id)
                        ->exists();

                    if ($exists) {
                        $fail("A semester with this exact name, start date, and end date already exists. You cannot create duplicate terms with the same exact timeframe.");
                    }
                }
            ],
        ]);

        $semester->update($validated);
        $semester->departments()->sync($request->department_ids);
        
        return back()->with('success', 'Semester updated successfully.');
    }

    public function destroy($id)
    {
        $semester = Semester::findOrFail($id);
        $semester->delete();
        return back()->with('success', 'Semester deleted successfully.');
    }
}
