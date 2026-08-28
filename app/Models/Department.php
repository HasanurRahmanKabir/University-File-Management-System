<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsGlobalActivity;

class Department extends Model
{
    use HasFactory, LogsGlobalActivity;

    protected $fillable = ['code', 'name', 'faculty'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function teachers()
    {
        return $this->hasMany(User::class)->where('role', 'teacher');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function semesters()
    {
        return $this->belongsToMany(Semester::class, 'department_semester');
    }
}
