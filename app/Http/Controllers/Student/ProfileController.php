<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the student's profile.
     */
    public function index()
    {
        $user = Auth::user();
        return view('student.profile', compact('user'));
    }

    /**
     * Display the account settings page.
     */
    public function settings()
    {
        $user = Auth::user();
        return view('student.settings', compact('user'));
    }

    /**
     * Update the student's account settings.
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
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
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
        
        // Handle profile image removal
        if ($request->has('remove_image') && $request->remove_image == '1') {
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $user->profile_image = null;
        }
        
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if it exists
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }
            
            // Store new image
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }
        
        $user->save();

        return redirect()->back()->with('success', 'Account settings updated successfully.');
    }
}
