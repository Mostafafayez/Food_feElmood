<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('main_image')->nullable();
            $table->text('review')->nullable();
            $table->text('location')->nullable();
            $table->string('food_type')->nullable();
            $table->enum('status', ['pending', 'recommend'])->default('pending');
       
        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
