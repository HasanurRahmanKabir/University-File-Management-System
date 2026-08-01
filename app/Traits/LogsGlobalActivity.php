<?php

namespace App\Traits;

use App\Notifications\GlobalActivityNotification;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

trait LogsGlobalActivity
{
    /**
     * Boot the trait to listen for Eloquent events.
     */
    protected static function bootLogsGlobalActivity()
    {
        static::created(function ($model) {
            $url = self::getModelUrl($model);
            $className = self::getModelName($model);
            self::notifyAdmins("New " . $className . " Created", "A new " . $className . " record was created successfully.", "fa-plus-circle", "success", $url);
        });

        static::updated(function ($model) {
            $url = self::getModelUrl($model);
            $className = self::getModelName($model);
            
            $changes = $model->getChanges();
            
            // Check if status was changed
            if (array_key_exists('is_active', $changes)) {
                $status = $model->is_active ? 'Activated' : 'Deactivated';
                $icon = $model->is_active ? 'fa-check-circle' : 'fa-ban';
                $color = $model->is_active ? 'success' : 'secondary';
                
                self::notifyAdmins("$className $status", "The $className status was changed to $status.", $icon, $color, $url);
            } else {
                self::notifyAdmins("$className Updated", "A $className record was updated.", "fa-edit", "warning", $url);
            }
        });

        static::deleted(function ($model) {
            $url = self::getModelUrl($model);
            $className = self::getModelName($model);
            self::notifyAdmins($className . " Deleted", "A " . $className . " record has been deleted.", "fa-trash-alt", "danger", $url);
        });
    }

    /**
     * Get a human-readable model name.
     */
    protected static function getModelName($model)
    {
        $className = class_basename($model);
        if ($className === 'StudentInfo' || $className === 'User') {
            return ucfirst($model->role ?? 'User');
        } elseif ($className === 'CourseMaterial') {
            return 'Course Material';
        }
        return $className;
    }

    /**
     * Get the index URL for the model's resource.
     */
    protected static function getModelUrl($model)
    {
        try {
            $table = $model->getTable();
            
            // Special handling for users table based on role
            if ($table === 'users') {
                if (isset($model->role)) {
                    if ($model->role === 'teacher') {
                        return route('admin.teacher-info.index');
                    } elseif ($model->role === 'admin' || $model->role === 'super_admin') {
                        return route('admin.admins.index');
                    }
                }
                return route('admin.student-info.index');
            }
            
            // Map table names to route names
            $routeMap = [
                'courses' => 'admin.courses.index',
                'departments' => 'admin.departments.index',
                'categories' => 'admin.categories.index',
                'subcategories' => 'admin.subcategories.index',
                'semesters' => 'admin.semesters.index',
                'course_materials' => 'admin.course-files.index',
            ];
            
            if (isset($routeMap[$table])) {
                return route($routeMap[$table]);
            }
        } catch (\Exception $e) {
            // Ignore route errors
        }
        return '#';
    }

    /**
     * Dispatch notification to admins.
     */
    protected static function notifyAdmins($title, $description, $icon, $color, $url = '#')
    {
        // Get all Admins and Super Admins
        $admins = User::whereIn('role', ['admin', 'super_admin'])->get();

        if ($admins->count() > 0) {
            Notification::send($admins, new GlobalActivityNotification($title, $description, $icon, $color, $url));
        }
    }
}
