<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $teacher   = Auth::user();
        $teacherId = $teacher->id;

        $teacherDepartmentId = $teacher->department_id;
        $activeSemesterIds   = \App\Models\Semester::running($teacherDepartmentId)->pluck('id')->toArray();

        $coursesQuery = Course::where('teacher_id', $teacherId);
        if (!empty($activeSemesterIds)) {
            $coursesQuery->whereIn('semester_id', $activeSemesterIds);
        } else {
            $coursesQuery->whereNull('id'); // no active semester → empty list
        }
        $courses = $coursesQuery->get();

        $announcements = CourseAnnouncement::with(['course', 'teacher'])
            ->where('teacher_id', $teacherId)
            ->latest()
            ->paginate(12);

        return view('teacher.announcements.index', compact('announcements', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id'    => 'required|exists:courses,id',
            'type'         => 'required|in:Notice,Assignment,Class Test (CT),Exam',
            'title'        => 'required|string|max:255',
            'topic_details'=> 'required|string',
            'deadline'     => 'nullable|date',
            'exam_date'    => 'nullable|date',
            'attachment'   => 'nullable|file|max:5120',
        ]);

        $data = $request->only(['course_id', 'type', 'title', 'topic_details', 'deadline', 'exam_date']);
        $data['teacher_id'] = Auth::id();

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('announcements', 'public');
        }

        $announcement = CourseAnnouncement::create($data);

        // Notify admins
        $admins = \App\Models\User::whereIn('role', ['admin', 'super_admin'])->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\AnnouncementCreatedNotification($announcement));
        }

        return redirect()->route('teacher.announcements.index')
            ->with('success', 'Announcement created successfully!');
    }

    public function update(Request $request, CourseAnnouncement $announcement)
    {
        // Ensure the teacher owns this announcement
        if ($announcement->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'course_id'    => 'required|exists:courses,id',
            'type'         => 'required|in:Notice,Assignment,Class Test (CT),Exam',
            'title'        => 'required|string|max:255',
            'topic_details'=> 'required|string',
            'deadline'     => 'nullable|date',
            'exam_date'    => 'nullable|date',
            'attachment'   => 'nullable|file|max:5120',
        ]);

        $data = $request->only(['course_id', 'type', 'title', 'topic_details', 'deadline', 'exam_date']);

        if ($request->hasFile('attachment')) {
            // Delete old file
            if ($announcement->attachment) {
                Storage::disk('public')->delete($announcement->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('announcements', 'public');
        }

        $announcement->update($data);

        return redirect()->route('teacher.announcements.index')
            ->with('success', 'Announcement updated successfully!');
    }

    public function destroy(CourseAnnouncement $announcement)
    {
        if ($announcement->teacher_id !== Auth::id()) {
            abort(403);
        }

        if ($announcement->attachment) {
            Storage::disk('public')->delete($announcement->attachment);
        }

        $announcement->delete();

        return redirect()->route('teacher.announcements.index')
            ->with('success', 'Announcement deleted successfully!');
    }
}
