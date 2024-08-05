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
        Schema::create('factories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('harvest_id');
            $table->dateTime('received_date');
            $table->string('initial_process');
            $table->float('semi_finished_quantity');
            $table->string('semi_finished_quality');
            $table->string('factory_name');
            $table->string('factory_address');
            $table->string('image');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('harvest_id')->references('id')->on('harvests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factories');
    }
};
