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
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parent()
    {
        return $this->belongsTo(CourseFolder::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(CourseFolder::class, 'parent_id');
    }

    public function materials()
    {
        return $this->hasMany(CourseMaterial::class, 'folder_id');
    }

    /**
     * Prefer withCount('materials') when present to avoid N+1 queries.
     */
    public function getMaterialsCountAttribute(): int
    {
        if (array_key_exists('materials_count', $this->attributes)) {
            return (int) $this->attributes['materials_count'];
        }

        return (int) $this->materials()->count();
    }

    /**
     * Visible to enrolled students only if this folder and all ancestors are public.
     */
    public function isVisibleToStudents(): bool
    {
        $node = $this;
        $guard = 0;
        while ($node && $guard < 20) {
            if (!$node->is_active) {
                return false;
            }
            if (!$node->parent_id) {
                break;
            }
            $node = $node->relationLoaded('parent') && $node->parent
                ? $node->parent
                : static::find($node->parent_id);
            $guard++;
        }

        return true;
    }

    /**
     * IDs of folders in a course that students may see (self + ancestors public).
     *
     * @return \Illuminate\Support\Collection<int, int>
     */
    public static function studentVisibleIdsForCourse(int $courseId)
    {
        $all = static::where('course_id', $courseId)->get()->keyBy('id');
        $visible = collect();

        foreach ($all as $folder) {
            $node = $folder;
            $ok = true;
            $guard = 0;
            while ($node && $guard < 20) {
                if (!$node->is_active) {
                    $ok = false;
                    break;
                }
                $node = $node->parent_id ? ($all[$node->parent_id] ?? null) : null;
                $guard++;
            }
            if ($ok) {
                $visible->push($folder->id);
            }
        }

        return $visible;
    }
}
