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
        Schema::create('waste_management', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('craftsman_id'); 
            $table->unsignedBigInteger('monitoring_id')->nullable();
            $table->string('waste_type');
            $table->string('management_method');
            $table->string('management_results');
            $table->string('image');
            $table->boolean('is_ref');
            $table->string('nft_token_id')->nullable();
            $table->string('qrcode')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waste_management');
    }
};
