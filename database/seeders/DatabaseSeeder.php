<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );

        // 2. Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Demo',
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // 3. Teacher
        User::updateOrCreate(
            ['email' => 'teacher@gmail.com'],
            [
                'name' => 'Teacher Demo',
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
                'role' => 'teacher',
                'is_active' => true,
            ]
        );

        // 4. Student
        User::updateOrCreate(
            ['email' => 'student@gmail.com'],
            [
                'name' => 'Student Demo',
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
                'role' => 'student',
                'is_active' => true,
            ]
        );
    }
}
