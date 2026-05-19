<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // exam_registrations has FK on exams - drop FK first, then exams, then recreate both
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('exam_registrations');
        Schema::dropIfExists('exams');
        Schema::enableForeignKeyConstraints();

        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->date('exam_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('max_students')->default(30);
            $table->timestamps();
        });

        Schema::create('exam_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
            $table->string('student_name');
            $table->string('country');
            $table->string('email');
            $table->string('phone');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('exam_registrations');
        Schema::dropIfExists('exams');
    }
};
