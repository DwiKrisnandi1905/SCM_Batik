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
        Schema::create('monitorings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('harvest_id');
            $table->unsignedBigInteger('factory_id');
            $table->unsignedBigInteger('craftsman_id');
            $table->unsignedBigInteger('certification_id');
            $table->unsignedBigInteger('waste_id');
            $table->unsignedBigInteger('distribution_id');
            $table->string('status');
            $table->dateTime('last_updated');
            $table->timestamps();

            $table->foreign('harvest_id')->references('id')->on('harvests');
            $table->foreign('factory_id')->references('id')->on('factories');
            $table->foreign('craftsman_id')->references('id')->on('craftsmen');
            $table->foreign('certification_id')->references('id')->on('certifications');
            $table->foreign('waste_id')->references('id')->on('waste_management');
            $table->foreign('distribution_id')->references('id')->on('distributions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitorings');
    }
};
