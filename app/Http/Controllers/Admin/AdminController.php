<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['admin', 'super_admin']);
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'active') {
                $query->where('is_active', true);
            } elseif ($request->status == 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->has('role_filter') && $request->role_filter != '') {
            $query->where('role', $request->role_filter);
        }
        
        $users = $query->latest()->paginate(15)->appends($request->all());

        // KPI calculations
        $totalAdmins = User::whereIn('role', ['admin', 'super_admin'])->count();
        $activeAdmins = User::whereIn('role', ['admin', 'super_admin'])->where('is_active', true)->count();
        $inactiveAdmins = $totalAdmins - $activeAdmins;

        return view('admin.admins', compact('users', 'totalAdmins', 'activeAdmins', 'inactiveAdmins'));
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-admins');

        $validated = $request->validate([
            'role' => 'required|in:admin,super_admin',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'contact_number' => 'nullable|string|max:20',
            'password' => ['required', Password::defaults()],
            'is_active' => 'required|boolean',
        ]);
        
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);
        return back()->with('success', 'Admin registered successfully.');
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('manage-admins');

        $user = User::findOrFail($id);
        $validated = $request->validate([
            'role' => 'required|in:admin,super_admin',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'contact_number' => 'nullable|string|max:20',
            'is_active' => 'required|boolean',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => ['required', Password::defaults()]]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);
        return back()->with('success', 'Admin updated successfully.');
    }

    public function destroy($id)
    {
        Gate::authorize('manage-admins');

        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'Admin deleted successfully.');
    }
}
