<?php

namespace App\Models;

class StudentInfo extends User
{
    /**
     * The table associated with the model.
     * Since students are users in our system, we map this directly to the users table.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The "booted" method of the model.
     * Automatically filters queries to only include students.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('student', function ($builder) {
            $builder->where('role', 'student');
        });
        
        static::creating(function ($model) {
            $model->role = 'student';
        });
    }
}
