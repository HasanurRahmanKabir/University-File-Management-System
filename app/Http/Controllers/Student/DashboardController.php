<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'courses' => Course::where('is_active', true)->count(),
            'materials' => CourseMaterial::count(),
        ];
        return view('student.dashboard', compact('stats'));
    }
}