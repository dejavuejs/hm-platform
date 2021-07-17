<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeekVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('week_videos', function (Blueprint $table) {
            $table->id();
            $table->string('week')->nullable();
            $table->string('class')->nullable();
            $table->string('date')->nullable();
            $table->string('subject')->nullable();
            $table->string('playlist')->nullable();
            $table->string('playlist_400k')->nullable();
            $table->string('playlist_600k')->nullable();
            $table->string('playlist_1m')->nullable();
            $table->string('playlist_1_5m')->nullable();
            $table->integer('rotation')->default(0);
            $table->string('job_id');
            $table->json('job')->nullable();
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
        Schema::dropIfExists('week_videos');
    }
}
