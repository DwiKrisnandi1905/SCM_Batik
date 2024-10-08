<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('craftsman_id');
            $table->string('batik_type');
            $table->unsignedBigInteger('monitoring_id')->nullable();
            $table->string('test_results');
            $table->string('certificate_number');
            $table->dateTime('issue_date');
            $table->string('image');
            $table->boolean('is_ref');
            $table->string('nft_token_id')->nullable();
            $table->string('qrcode')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('craftsman_id')->references('id')->on('craftsmen');
        });
    }

    public function down()
    {
        Schema::dropIfExists('certifications');
    }
};
