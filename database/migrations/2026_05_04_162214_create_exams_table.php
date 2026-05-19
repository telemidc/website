<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// This file intentionally left empty - exams table is fully defined in update_exams_table.php
// which runs after all dependencies are created
return new class extends Migration {
    public function up(): void {
        // The old exams table (course_name) is dropped and recreated in update_exams_table.php
        // Nothing to do here
    }
    public function down(): void {}
};
