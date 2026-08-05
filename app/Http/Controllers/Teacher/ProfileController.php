<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the teacher's profile.
     */
    public function index()
    {
        $user = Auth::user();
        return view('teacher.profile', compact('user'));
    }

    /**
     * Display the account settings page.
     */
    public function settings()
    {
        $user = Auth::user();
        return view('teacher.settings', compact('user'));
    }

    /**
     * Update the teacher's account settings.
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'contact_number' => ['nullable', 'string', 'max:20'],
            'current_password' => ['nullable', 'required_with:password', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // If they provided a new password, check current password
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if ($request->has('contact_number')) {
            $user->contact_number = $validated['contact_number'];
        }
        
        // This save() will automatically trigger LogsGlobalActivity which notifies admins
        $user->save();

        return redirect()->back()->with('success', 'Account settings updated successfully.');
    }
}
