<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('factories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('harvest_id');
            $table->unsignedBigInteger('monitoring_id')->nullable();
            $table->dateTime('received_date');
            $table->string('initial_process');
            $table->float('semi_finished_quantity');
            $table->string('semi_finished_quality');
            $table->string('factory_name');
            $table->string('factory_address');
            $table->string('image');
            $table->boolean('is_ref');
            $table->string('nft_token_id')->nullable();
            $table->string('qrcode')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('harvest_id')->references('id')->on('harvests');
        });
    }

    public function down()
    {
        Schema::dropIfExists('factories');
    }
};
