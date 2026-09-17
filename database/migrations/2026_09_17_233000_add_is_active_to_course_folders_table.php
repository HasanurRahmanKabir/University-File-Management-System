<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_folders', function (Blueprint $table) {
            // true = Visible to students; false = Only Me (teacher only)
            $table->boolean('is_active')->default(true)->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('course_folders', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
