<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('teacher_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('field_id')->constrained()->cascadeOnDelete();
            $table->string('phone');
            $table->text('bio');
            $table->string('email');
            $table->enum('status', ['pending', 'hired', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('teacher_applications'); }
};
