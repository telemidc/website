<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('teacher_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_application_id')->constrained()->cascadeOnDelete();
            $table->string('contract_duration');
            $table->text('contract_text');
            $table->decimal('salary', 10, 2);
            $table->date('start_date');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('teacher_contracts'); }
};
