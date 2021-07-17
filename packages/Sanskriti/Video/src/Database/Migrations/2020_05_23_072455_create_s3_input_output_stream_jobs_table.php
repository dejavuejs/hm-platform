<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateS3InputOutputStreamJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s3_input_output_stream_jobs', function (Blueprint $table) {
            $table->id();
            $table->json('input')->nullable();
            $table->string('input_bucket')->nullable();
            $table->string('input_key')->nullable();
            $table->string('output_bucket')->nullable();
            $table->string('output_key')->nullable();
            $table->string('segment_duration')->nullable();
            $table->json('input_info')->nullable();
            $table->json('output_info')->nullable();
            $table->boolean('complete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s3_input_output_stream');
    }
}
