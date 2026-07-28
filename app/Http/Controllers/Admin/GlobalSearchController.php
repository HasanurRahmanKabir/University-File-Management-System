<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Department;
use App\Models\Category;
use App\Models\Subcategory;

class GlobalSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $results = [];

        // 1. Search Users (Students, Teachers, Admins)
        $users = User::where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->orWhere('student_id', 'like', "%{$query}%")
                    ->limit(5)
                    ->get();
        
        if ($users->isNotEmpty()) {
            $results['Users'] = $users->map(function ($user) {
                $icon = 'fa-user';
                $route = '#';
                $color = 'text-primary';
                
                if ($user->role === 'student') {
                    $icon = 'fa-user-graduate';
                    $route = route('admin.student-info.index') . '?search=' . urlencode($user->name);
                    $color = 'text-success';
                } elseif ($user->role === 'teacher') {
                    $icon = 'fa-chalkboard-teacher';
                    $route = route('admin.teacher-info.index') . '?search=' . urlencode($user->name);
                    $color = 'text-info';
                } elseif ($user->role === 'admin' || $user->role === 'super_admin') {
                    $icon = 'fa-user-shield';
                    $route = route('admin.admins.index') . '?search=' . urlencode($user->name);
                    $color = 'text-danger';
                }
                
                return [
                    'title' => $user->name,
                    'subtitle' => ucfirst(str_replace('_', ' ', $user->role)) . ($user->student_id ? ' - ' . $user->student_id : ''),
                    'icon' => $icon,
                    'color' => $color,
                    'url' => $route
                ];
            });
        }

        // 2. Search Courses
        $courses = Course::where('title', 'like', "%{$query}%")
                        ->orWhere('course_code', 'like', "%{$query}%")
                        ->limit(4)
                        ->get();
        
        if ($courses->isNotEmpty()) {
            $results['Courses'] = $courses->map(function ($course) {
                return [
                    'title' => $course->title,
                    'subtitle' => 'Course Code: ' . $course->course_code,
                    'icon' => 'fa-book-open',
                    'color' => 'text-primary',
                    'url' => route('admin.courses.index') . '?search=' . urlencode($course->title)
                ];
            });
        }

        // 3. Search Departments
        $departments = Department::where('name', 'like', "%{$query}%")
                                ->orWhere('code', 'like', "%{$query}%")
                                ->limit(3)
                                ->get();
                                
        if ($departments->isNotEmpty()) {
            $results['Departments'] = $departments->map(function ($dept) {
                return [
                    'title' => $dept->name,
                    'subtitle' => 'Code: ' . $dept->code,
                    'icon' => 'fa-building-columns',
                    'color' => 'text-warning',
                    'url' => route('admin.departments.index') . '?search=' . urlencode($dept->name)
                ];
            });
        }

        // 4. Search Categories
        $categories = Category::where('name', 'like', "%{$query}%")
                            ->limit(3)
                            ->get();
                            
        if ($categories->isNotEmpty()) {
            $results['Categories'] = $categories->map(function ($cat) {
                return [
                    'title' => $cat->name,
                    'subtitle' => 'Core Category',
                    'icon' => 'fa-tags',
                    'color' => 'text-purple', // Tailwind or custom class
                    'url' => route('admin.categories.index') . '?search=' . urlencode($cat->name)
                ];
            });
        }
        
        // 5. Search Subcategories
        $subcategories = Subcategory::where('name', 'like', "%{$query}%")
                            ->limit(3)
                            ->get();
                            
        if ($subcategories->isNotEmpty()) {
            $results['Subcategories'] = $subcategories->map(function ($subcat) {
                return [
                    'title' => $subcat->name,
                    'subtitle' => 'Subcategory',
                    'icon' => 'fa-layer-group',
                    'color' => 'text-teal',
                    'url' => route('admin.subcategories.index') . '?search=' . urlencode($subcat->name)
                ];
            });
        }

        return response()->json($results);
    }
}
