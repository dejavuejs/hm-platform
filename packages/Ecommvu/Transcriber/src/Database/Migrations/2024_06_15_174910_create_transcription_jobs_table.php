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
        Schema::create('transcription_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('source_path')->nullable();
            $table->string('status_label')->nullable();
            $table->boolean('status')->default(false);
            $table->json('transcription_result')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transcription_jobs');
    }
};
