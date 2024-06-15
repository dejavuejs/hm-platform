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
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('timezone')->nullable();
            $table->string('theme')->nullable();
            $table->string('hostname')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->text('home_page_content')->nullable();
            $table->text('footer_content')->nullable();
            $table->unsignedBigInteger('default_locale_id');
            $table->unsignedBigInteger('base_currency_id');
            $table->foreign('default_locale_id')->references('id')->on('locales');
            $table->foreign('base_currency_id')->references('id')->on('currencies');
            $table->unsignedBigInteger('root_category_id')->nullable();
            $table->foreign('root_category_id')->references('id')->on('categories')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('channel_locales', function (Blueprint $table) {
            $table->unsignedBigInteger('channel_id');
            $table->unsignedBigInteger('locale_id');
            $table->primary(['channel_id', 'locale_id']);
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('cascade');
            $table->foreign('locale_id')->references('id')->on('locales')->onDelete('cascade');
        });

        Schema::create('channel_currencies', function (Blueprint $table) {
            $table->unsignedBigInteger('channel_id');
            $table->unsignedBigInteger('currency_id');
            $table->primary(['channel_id', 'currency_id']);
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channels');

        Schema::dropIfExists('channel_currencies');
    }
};