<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'seo_meta_description', 'value' => 'University OBE File Management System'],
            ['key' => 'system_email', 'value' => 'admin@university.com'],
            ['key' => 'academic_session', 'value' => '2025-2026'],
            ['key' => 'brand_tagline', 'value' => 'File Management'],
            ['key' => 'footer_copyright', 'value' => '© 2026 University File Management System'],
            ['key' => 'admin_dashboard_name', 'value' => 'UniAdmin'],
            ['key' => 'admin_tab_title', 'value' => 'University Admin Panel'],
            ['key' => 'teacher_dashboard_name', 'value' => 'Teacher Panel'],
            ['key' => 'teacher_tab_title', 'value' => 'Teacher Portal'],
            ['key' => 'student_dashboard_name', 'value' => 'Student Portal'],
            ['key' => 'student_tab_title', 'value' => 'Student Dashboard'],
            ['key' => 'login_title', 'value' => 'Welcome to UniAdmin'],
            ['key' => 'login_subtitle', 'value' => 'Please sign in to your account'],
            ['key' => 'login_tab_title', 'value' => 'Login — UniAdmin'],
            ['key' => 'login_logo_tagline', 'value' => 'University File Management System'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
