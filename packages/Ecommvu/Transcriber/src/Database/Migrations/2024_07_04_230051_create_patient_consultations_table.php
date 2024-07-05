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
        Schema::create('patient_consultations', function (Blueprint $table) {
            $table->id();
            $table->string('transcript_path')->nullable();
            $table->boolean('transcription_status')->default(true);
            $table->string('prescription_notes_path')->nullable();
            $table->string('assistant_notes_path')->nullable();
            $table->string('feedback_notes_path')->nullable();
            $table->string('prescription_notes_thread_id')->nullable();
            $table->string('assistant_notes_thread_id')->nullable();
            $table->string('feedback_notes_thread_id')->nullable();
            $table->string('prescription_notes_link')->nullable();
            $table->string('assistant_notes_link')->nullable();
            $table->string('feedback_notes_link')->nullable();
            $table->string('patient_name')->nullable();
            $table->string('case_id')->nullable();
            $table->mediumText('case_description')->nullable();
            $table->string('clinic_name')->nullable();
            $table->string('status_label')->nullable();
            $table->string('status')->default(false);
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
