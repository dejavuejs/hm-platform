<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patient_case_consultations', function (Blueprint $table) {
            $table->id();
            $table->string('transcript_path')->nullable();
            $table->string('prescription_notes_path')->nullable();
            $table->string('assistant_notes_path')->nullable();
            $table->string('feedback_notes_path')->nullable();
            $table->string('prescription_notes_thread_id')->nullable();
            $table->string('assistant_notes_thread_id')->nullable();
            $table->string('feedback_notes_thread_id')->nullable();
            $table->unsignedBigInteger('patient_case_id');
            $table->foreign('patient_case_id')->on('patient_cases')->references('id')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_case_notes');
    }
};
