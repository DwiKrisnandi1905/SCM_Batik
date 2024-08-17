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
        Schema::create('craftsmen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('factory_id');
            $table->string('production_details');
            $table->float('finished_quantity');
            $table->unsignedBigInteger('monitoring_id')->nullable();
            $table->dateTime('completion_date');
            $table->string('image');
            $table->boolean('is_ref');
            $table->string('nft_token_id')->nullable();
            $table->string('qrcode')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('factory_id')->references('id')->on('factories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('craftsmen');
    }
};
