<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CourseAnnouncement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = CourseAnnouncement::with(['course', 'teacher'])
            ->latest()
            ->paginate(15);
            
        return view('admin.announcements.index', compact('announcements'));
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
