<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsGlobalActivity;

class CourseMaterial extends Model
{
    use HasFactory, LogsGlobalActivity;

    protected $fillable = [
        'course_id',
        'folder_id',
        'uploaded_by',
        'title',
        'file_path',
        'file_type',
        'file_size',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * The folder this material belongs to (nullable — null = root).
     */
    public function folder()
    {
        return $this->belongsTo(CourseFolder::class, 'folder_id');
    }
}
