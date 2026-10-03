<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_announcements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('teacher_id');
            $table->enum('type', ['Notice', 'Assignment', 'Class Test (CT)', 'Exam'])->default('Notice');
            $table->string('title');
            $table->text('topic_details');
            $table->dateTime('deadline')->nullable();
            $table->dateTime('exam_date')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_announcements');
    }
};
