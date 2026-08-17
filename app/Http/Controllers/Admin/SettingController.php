<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.system-settings', compact('settings'));
    }

    public function update(Request $request)
    {
        // Add remove_* to the except array
        $data = $request->except([
            '_token', 
            'admin_logo', 'teacher_logo', 'student_logo', 'login_logo',
            'remove_admin_logo', 'remove_teacher_logo', 'remove_student_logo', 'remove_login_logo'
        ]);

        // Update standard text fields
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Handle file uploads (Logos)
        $logos = ['admin_logo', 'teacher_logo', 'student_logo', 'login_logo'];

        foreach ($logos as $logo) {
            $removeKey = 'remove_' . $logo;
            
            // If user clicked remove
            if ($request->input($removeKey) == '1') {
                $setting = Setting::where('key', $logo)->first();
                if ($setting) {
                    if (Storage::disk('public')->exists($setting->value)) {
                        Storage::disk('public')->delete($setting->value);
                    }
                    $setting->delete();
                }
            } 
            // Else if user uploaded a new file
            elseif ($request->hasFile($logo)) {
                $setting = Setting::where('key', $logo)->first();
                if ($setting && Storage::disk('public')->exists($setting->value)) {
                    Storage::disk('public')->delete($setting->value);
                }

                $file = $request->file($logo);
                $path = $file->store('logos', 'public');
                
                Setting::updateOrCreate(['key' => $logo], ['value' => $path]);
            }
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
