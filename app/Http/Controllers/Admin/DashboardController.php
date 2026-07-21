<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = now()->month;
        $lastMonth = now()->subMonth()->month;

        $stats = [
            'students' => User::where('role', 'student')->count(),
            'teachers' => User::where('role', 'teacher')->count(),
            'categories' => Category::count(),
            'courses' => Course::count(),
            'files' => CourseMaterial::count()
        ];
        
        $calcGrowth = function($current, $last) {
            if ($last == 0) return $current > 0 ? 100 : 0;
            return round((($current - $last) / $last) * 100);
        };

        $trends = [
            'students' => $calcGrowth(
                User::where('role', 'student')->whereMonth('created_at', $currentMonth)->count(),
                User::where('role', 'student')->whereMonth('created_at', $lastMonth)->count()
            ),
            'teachers' => $calcGrowth(
                User::where('role', 'teacher')->whereMonth('created_at', $currentMonth)->count(),
                User::where('role', 'teacher')->whereMonth('created_at', $lastMonth)->count()
            ),
            'courses' => $calcGrowth(
                Course::whereMonth('created_at', $currentMonth)->count(),
                Course::whereMonth('created_at', $lastMonth)->count()
            ),
            'files' => $calcGrowth(
                CourseMaterial::whereMonth('created_at', $currentMonth)->count(),
                CourseMaterial::whereMonth('created_at', $lastMonth)->count()
            )
        ];
        
        $recentRecords = User::latest()->take(5)->get();
        $recentActivities = \App\Models\ActivityLog::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'trends', 'recentRecords', 'recentActivities'));
    }

    public function storeRecord(Request $request)
    {
        $request->validate([
            'classification' => 'required|in:Student,Teacher,Admin,Course',
            'name' => 'required|string|max:255',
            'id_email' => 'required|string|max:255'
        ]);

        if ($request->classification !== 'Course') {
            $isEmail = str_contains($request->id_email, '@');
            $exists = User::where(function ($q) use ($isEmail, $request) {
                if ($isEmail) {
                    $q->where('email', $request->id_email);
                } else {
                    $q->where('student_id', $request->id_email);
                }
            })->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'A User With This Email or ID Already Exists!')->withInput();
            }
        }

        if ($request->classification == 'Course') {
            Course::create([
                'course_code' => $request->id_email,
                'course_name' => $request->name,
                'category_id' => Category::first()->id ?? 1 // Fallback
            ]);
            $desc = "New course <strong>{$request->name}</strong> registered";
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => str_contains($request->id_email, '@') ? $request->id_email : null,
                'student_id' => str_contains($request->id_email, '@') ? null : $request->id_email,
                'password' => bcrypt('password'), // Default password
                'role' => strtolower($request->classification)
            ]);
            $desc = "<strong>{$user->name}</strong> was registered as " . $request->classification;
        }

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created_record',
            'description' => $desc
        ]);

        return redirect()->back()->with('success', 'Record Created Successfully!');
    }

    public function updateRecord(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:student,teacher,admin',
            'reference' => 'required|string|max:255'
        ]);

        $isEmail = str_contains($request->reference, '@');
        $exists = User::where('id', '!=', $id)->where(function ($q) use ($isEmail, $request) {
            if ($isEmail) {
                $q->where('email', $request->reference);
            } else {
                $q->where('student_id', $request->reference);
            }
        })->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This Email or ID Is Already Assigned To Another User!')->withInput();
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->role = $request->role;
        if (str_contains($request->reference, '@')) {
            $user->email = $request->reference;
        } else {
            $user->student_id = $request->reference;
        }
        $user->save();

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated_record',
            'description' => "Updated credentials for <strong>{$user->name}</strong>"
        ]);

        return redirect()->back()->with('success', 'Record Updated Successfully!');
    }

    public function deleteRecord($id)
    {
        if ($id == auth()->id()) {
            return redirect()->back()->with('error', 'You Cannot Delete Your Own Account!');
        }

        $user = User::findOrFail($id);
        $name = $user->name;
        $user->delete();

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted_record',
            'description' => "Deleted record for <strong>{$name}</strong>"
        ]);

        return redirect()->back()->with('success', 'Record Deleted Successfully!');
    }
}