<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('course_teachers', function (Blueprint $table) {
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('teacher_application_id')->references('id')->on('teacher_applications')->onDelete('cascade');
        });
        // also fix exam_registrations - ensure exams table is updated before this
        Schema::table('exams', function (Blueprint $table) {
            if (!Schema::hasColumn('exams', 'subject_id')) {
                $table->unsignedBigInteger('subject_id')->after('id');
                $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            }
        });
    }
    public function down(): void {
        Schema::table('course_teachers', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropForeign(['teacher_application_id']);
        });
    }
};
