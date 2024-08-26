<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('craftsman_factory', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('craftsman_id')->nullable()->constrained('craftsmen', 'id')->onDelete('cascade');
            $table->foreignId('factory_id')->nullable()->constrained('factories', 'id')->onDelete('cascade');
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('craftsman_factories');
    }
};
