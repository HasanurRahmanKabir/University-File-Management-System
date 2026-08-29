<?php

namespace App\Notifications;

use App\Models\CourseAnnouncement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AnnouncementCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(public CourseAnnouncement $announcement) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'New announcement: ' . $this->announcement->title,
            'type'    => $this->announcement->type,
            'course'  => optional($this->announcement->course)->course_code,
            'teacher' => optional($this->announcement->teacher)->name,
            'url'     => '/admin/dashboard',
        ];
    }
}
