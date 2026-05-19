<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('field_id')->constrained()->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_visible')->default(true);
            $table->unsignedInteger('max_students')->default(30);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('courses'); }
};
