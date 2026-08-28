<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\LogsGlobalActivity;

class Semester extends Model
{
    use HasFactory, LogsGlobalActivity;

    protected $fillable = ['name', 'year', 'start_date', 'end_date', 'is_active'];

    public function departments()
    {
        return $this->belongsToMany(\App\Models\Department::class, 'department_semester');
    }

    /**
     * Scope a query to only include "running" semesters.
     * A semester is running if it is explicitly active AND its end_date has not passed.
     */
    public function scopeRunning($query, $departmentId = null)
    {
        $q = $query->where('is_active', true)
                     ->where(function ($q) {
                         $q->whereNull('end_date')
                           ->orWhere('end_date', '>=', now()->toDateString());
                     });
                     
        if ($departmentId) {
            $q->whereHas('departments', function($q2) use ($departmentId) {
                $q2->where('departments.id', $departmentId);
            });
        }
        
        return $q;
    }
}
