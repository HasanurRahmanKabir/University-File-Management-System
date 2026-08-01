<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsGlobalActivity;

class Course extends Model {
    use HasFactory, SoftDeletes, LogsGlobalActivity;
    protected $fillable = [
        'department_id', 'category_id', 'subcategory_id', 'teacher_id', 'title', 'subtitle', 'course_code', 'slug', 'description', 'thumbnail', 'is_active'
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function department() {
        return $this->belongsTo(Department::class);
    }
    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function subcategory() {
        return $this->belongsTo(Subcategory::class);
    }
    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function materials() {
        return $this->hasMany(CourseMaterial::class);
    }
}