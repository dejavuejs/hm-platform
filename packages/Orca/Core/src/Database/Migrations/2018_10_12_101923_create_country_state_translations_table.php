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
        Schema::create('country_state_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale');
            $table->text('name')->nullable();

            $table->unsignedBigInteger('country_state_id');
            $table->foreign('country_state_id')->references('id')->on('country_states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country_state_translations');
    }
};