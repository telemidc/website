<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_number')->unique();
            $table->foreignId('course_registration_id')->constrained()->cascadeOnDelete();
            $table->string('grade');
            $table->text('notes')->nullable();
            $table->date('issued_at');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('certificates'); }
};
