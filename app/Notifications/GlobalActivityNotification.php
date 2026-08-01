<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GlobalActivityNotification extends Notification
{
    use Queueable;

    public $title;
    public $description;
    public $icon;
    public $color;
    public $url;

    /**
     * Create a new notification instance.
     */
    public function __construct($title, $description, $icon = 'fa-info-circle', $color = 'primary', $url = '#')
    {
        $this->title = $title;
        $this->description = $description;
        $this->icon = $icon;
        $this->color = $color;
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'icon' => $this->icon,
            'color' => $this->color,
            'url' => $this->url,
        ];
    }
}
