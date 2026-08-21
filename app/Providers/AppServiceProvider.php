<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;
use App\Models\Setting;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (Schema::hasTable('settings')) {
                $globalSettings = Setting::pluck('value', 'key')->toArray();
                View::share('globalSettings', $globalSettings);
            }
        } catch (\Exception $e) {
            // Ignore during migrations or initial setup
        }

        Gate::define('manage-admins', function (User $user) {
            return $user->role === 'super_admin';
        });
    }
}
