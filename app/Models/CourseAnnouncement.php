<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseAnnouncement extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'teacher_id', 'type', 'title', 'topic_details',
        'deadline', 'exam_date', 'attachment',
    ];

    protected $casts = [
        'deadline'  => 'datetime',
        'exam_date' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
