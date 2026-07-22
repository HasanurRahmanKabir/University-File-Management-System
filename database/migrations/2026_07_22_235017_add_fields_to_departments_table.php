<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->string('code', 20)->after('id')->nullable(); // e.g. CSE
            $table->string('full_name')->after('name')->nullable(); // e.g. Computer Science and Engineering
            $table->text('description')->after('full_name')->nullable();
            $table->boolean('is_active')->after('description')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn(['code', 'full_name', 'description', 'is_active']);
        });
    }
};
