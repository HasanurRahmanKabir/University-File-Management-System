<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseFolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'parent_id',
        'name',
        'created_by',
    ];

    /**
     * The course this folder belongs to.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * The user who created this folder.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Parent folder (for sub-folders).
     */
    public function parent()
    {
        return $this->belongsTo(CourseFolder::class, 'parent_id');
    }

    /**
     * Child sub-folders.
     */
    public function children()
    {
        return $this->hasMany(CourseFolder::class, 'parent_id');
    }

    /**
     * All materials directly inside this folder.
     */
    public function materials()
    {
        return $this->hasMany(CourseMaterial::class, 'folder_id');
    }

    /**
     * Total file count inside this folder (direct children only).
     */
    public function getMaterialsCountAttribute(): int
    {
        return $this->materials()->count();
    }
}
