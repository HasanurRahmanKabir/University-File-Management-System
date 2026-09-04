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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');
            $table->enum('status', ['active', 'dropped'])->default('active');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            
            // A user can only enroll in a specific course once
            $table->unique(['user_id', 'course_id']);
        });

        // Migrate Data from users.enrolled_courses to enrollments
        $students = \Illuminate\Support\Facades\DB::table('users')
                        ->where('role', 'student')
                        ->whereNotNull('enrolled_courses')
                        ->get();

        $enrollments = [];
        $now = now();

        foreach ($students as $student) {
            $courses = json_decode($student->enrolled_courses, true);
            if (is_array($courses)) {
                foreach ($courses as $courseId) {
                    $enrollments[] = [
                        'user_id' => $student->id,
                        'course_id' => $courseId,
                        'status' => 'active',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        // Insert in chunks to avoid memory issues
        foreach (array_chunk($enrollments, 1000) as $chunk) {
            \Illuminate\Support\Facades\DB::table('enrollments')->insertOrIgnore($chunk);
        }

        // Drop enrolled_courses column from users
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('enrolled_courses');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('enrolled_courses')->nullable();
        });

        // Restore data (basic restore from enrollments)
        $enrollments = \Illuminate\Support\Facades\DB::table('enrollments')->get();
        $grouped = $enrollments->groupBy('user_id');
        
        foreach ($grouped as $userId => $userEnrollments) {
            $courseIds = $userEnrollments->pluck('course_id')->toArray();
            \Illuminate\Support\Facades\DB::table('users')
                ->where('id', $userId)
                ->update(['enrolled_courses' => json_encode($courseIds)]);
        }

        Schema::dropIfExists('enrollments');
    }
};
