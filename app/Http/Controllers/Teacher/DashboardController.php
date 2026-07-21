<?php
namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'my_courses' => Course::where('teacher_id', Auth::id())->count(),
            'materials' => CourseMaterial::whereHas('course', function($q){ $q->where('teacher_id', Auth::id()); })->count(),
        ];
        return view('teacher.dashboard', compact('stats'));
    }
}