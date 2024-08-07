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
        Schema::create('distributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('craftsman_id');
            $table->string('destination');
            $table->float('quantity');
            $table->dateTime('shipment_date');
            $table->string('tracking_number');
            $table->dateTime('received_date');
            $table->string('receiver_name');
            $table->string('received_condition');
            $table->string('image');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('craftsman_id')->references('id')->on('craftsmen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distributions');
    }
};
