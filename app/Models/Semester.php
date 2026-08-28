<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\LogsGlobalActivity;

class Semester extends Model
{
    use HasFactory, LogsGlobalActivity;

    protected $fillable = ['name', 'year', 'start_date', 'end_date', 'is_active'];

    /**
     * Scope a query to only include "running" semesters.
     * A semester is running if it is explicitly active AND its end_date has not passed.
     */
    public function scopeRunning($query)
    {
        return $query->where('is_active', true)
                     ->where(function ($q) {
                         $q->whereNull('end_date')
                           ->orWhere('end_date', '>=', now()->toDateString());
                     });
    }
}
