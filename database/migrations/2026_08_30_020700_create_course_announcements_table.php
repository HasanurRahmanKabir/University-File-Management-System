<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_announcements', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->after('id');
            $table->unsignedBigInteger('teacher_id')->after('course_id');
            $table->enum('type', ['Notice', 'Assignment', 'Class Test (CT)', 'Exam'])->default('Notice')->after('teacher_id');
            $table->string('title')->after('type');
            $table->text('topic_details')->after('title');
            $table->dateTime('deadline')->nullable()->after('topic_details');
            $table->dateTime('exam_date')->nullable()->after('deadline');
            $table->string('attachment')->nullable()->after('exam_date');

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('course_announcements', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropForeign(['teacher_id']);
            $table->dropColumn(['course_id', 'teacher_id', 'type', 'title', 'topic_details', 'deadline', 'exam_date', 'attachment']);
        });
    }
};
