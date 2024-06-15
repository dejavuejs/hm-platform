<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subject');
            $table->boolean('status')->default(0);
            $table->string('type');
            $table->string('mail_to');
            $table->string('spooling')->nullable();

            $table->unsignedBigInteger('channel_id')->nullable();
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('set null');

            $table->unsignedBigInteger('customer_group_id')->nullable();
            $table->foreign('customer_group_id')->references('id')->on('customer_groups')->onDelete('set null');

            $table->unsignedBigInteger('marketing_template_id')->nullable();
            $table->foreign('marketing_template_id')->references('id')->on('marketing_templates')->onDelete('set null');

            $table->unsignedBigInteger('marketing_event_id')->nullable();
            $table->foreign('marketing_event_id')->references('id')->on('marketing_events')->onDelete('set null');

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
        Schema::dropIfExists('marketing_campaigns');
    }
};