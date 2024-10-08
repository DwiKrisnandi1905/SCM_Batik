<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nft_config', function (Blueprint $table) {
            $table->id();
            $table->string('fromAddress')->nullable();
            $table->string('contractAddress')->nullable();
            $table->longText('abi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nft_config');
    }
};
