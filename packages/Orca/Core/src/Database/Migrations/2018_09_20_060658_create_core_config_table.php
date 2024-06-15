<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_config', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->longText('value');
            // $table->unsignedBigInteger('channel_code');
            $table->string('channel_code')->nullable();
            $table->string('locale_code')->nullable();
            $table->timestamps();
            // $table->foreign('channel_id')->references('id')->on('channels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_config');
    }
};