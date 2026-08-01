<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\LogsGlobalActivity;

class Semester extends Model
{
    use HasFactory, LogsGlobalActivity;

    protected $fillable = ['name', 'year', 'start_date', 'end_date', 'is_active'];
}
