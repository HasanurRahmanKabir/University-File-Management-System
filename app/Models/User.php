<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'student_id', 'semester', 'email', 'password', 'role', 'is_active', 'enrolled_courses', 'profile_image', 'department_id', 'designation', 'contact_number'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the courses taught by this user (if teacher).
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    /**
     * Get the materials uploaded by this user.
     */
    public function uploadedMaterials()
    {
        return $this->hasMany(CourseMaterial::class, 'uploaded_by');
    }

    /**
     * Get the department of this user.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
