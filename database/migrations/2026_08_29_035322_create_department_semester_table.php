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
        Schema::create('department_semester', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            
            $table->unique(['department_id', 'semester_id']); // Prevent duplicate pivot entries
        });

        // Drop the department_id column from semesters table
        if (Schema::hasColumn('semesters', 'department_id')) {
            Schema::table('semesters', function (Blueprint $table) {
                // Drop foreign key first if it exists
                // We'll use try-catch in case the constraint name is different or doesn't exist
                try {
                    $table->dropForeign(['department_id']);
                } catch (\Exception $e) {}
                
                $table->dropColumn('department_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('semesters', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
        });
        
        Schema::dropIfExists('department_semester');
    }
};
