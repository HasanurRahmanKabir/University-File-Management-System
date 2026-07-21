<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'teacher')->latest()->paginate(15);
        return view('admin.teacher', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Password::defaults()],
        ]);
        
        $validated['role'] = 'teacher';
        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = true;

        User::create($validated);
        return back()->with('success', 'Teacher created successfully.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => ['required', Password::defaults()]]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);
        return back()->with('success', 'Teacher updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'Teacher deleted successfully.');
    }
}
