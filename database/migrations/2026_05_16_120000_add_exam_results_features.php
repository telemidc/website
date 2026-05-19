<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // 1. Add status to exams
        Schema::table('exams', function (Blueprint $table) {
            $table->enum('status', ['announced', 'completed'])->default('announced')->after('max_students');
        });

        // 2. Add score & grade to exam_registrations
        Schema::table('exam_registrations', function (Blueprint $table) {
            $table->unsignedSmallInteger('score')->nullable()->after('phone');
            $table->string('grade', 50)->nullable()->after('score');
        });

        // 3. Add exam_registration_id to certificates (nullable — for exam-based certs)
        Schema::table('certificates', function (Blueprint $table) {
            $table->foreignId('exam_registration_id')
                  ->nullable()
                  ->after('course_registration_id')
                  ->constrained('exam_registrations')
                  ->nullOnDelete();
            $table->string('course_name', 255)->nullable()->after('exam_registration_id');
        });
    }

    public function down(): void {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropForeign(['exam_registration_id']);
            $table->dropColumn(['exam_registration_id', 'course_name']);
        });
        Schema::table('exam_registrations', function (Blueprint $table) {
            $table->dropColumn(['score', 'grade']);
        });
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
