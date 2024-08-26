<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('monitorings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('harvest_id')->nullable();
            $table->unsignedBigInteger('craftsman_id')->nullable();
            $table->unsignedBigInteger('certification_id')->nullable();
            $table->unsignedBigInteger('waste_id')->nullable();
            $table->unsignedBigInteger('distribution_id')->nullable();
            $table->dateTime('last_updated');
            $table->timestamps();

            $table->foreign('harvest_id')->references('id')->on('harvests')->onDelete('cascade');
            $table->foreign('craftsman_id')->references('id')->on('craftsmen')->onDelete('cascade');
            $table->foreign('certification_id')->references('id')->on('certifications')->onDelete('cascade');
            $table->foreign('waste_id')->references('id')->on('waste_management')->onDelete('cascade');
            $table->foreign('distribution_id')->references('id')->on('distributions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('monitorings');
    }
};
