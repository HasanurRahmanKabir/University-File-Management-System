<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CourseAnnouncement;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = CourseAnnouncement::with(['course', 'teacher']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('topic_details', 'like', "%{$search}%")
                  ->orWhereHas('course', function($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%")
                        ->orWhere('course_code', 'like', "%{$search}%");
                  })
                  ->orWhereHas('teacher', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('type_filter') && $request->type_filter != '') {
            $query->where('type', $request->type_filter);
        }

        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'Exam') {
                $query->whereIn('type', ['Exam', 'Class Test (CT)']);
            } else {
                $query->where('type', $request->status);
            }
        }

        $announcements = $query->latest()->paginate(15)->appends($request->all());
        
        $totalAnnouncements = CourseAnnouncement::count();
        $assignmentCount = CourseAnnouncement::where('type', 'Assignment')->count();
        $examCtCount = CourseAnnouncement::whereIn('type', ['Exam', 'Class Test (CT)'])->count();
        
        $types = CourseAnnouncement::select('type')->distinct()->pluck('type');
            
        return view('admin.announcements.index', compact('announcements', 'totalAnnouncements', 'assignmentCount', 'examCtCount', 'types'));
    }

    public function destroy(CourseAnnouncement $announcement)
    {
        // Delete attachment if exists
        if ($announcement->attachment && \Illuminate\Support\Facades\Storage::disk('public')->exists($announcement->attachment)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($announcement->attachment);
        }
        
        $announcement->delete();

        return redirect()->back()->with('success', 'Announcement deleted successfully!');
    }
}
