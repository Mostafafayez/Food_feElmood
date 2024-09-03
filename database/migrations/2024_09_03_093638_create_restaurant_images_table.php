<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateRestaurantImagesTable extends Migration
{
    public function up()
    {
        Schema::create('restaurant_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('image_url');

        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurant_images');
    }
}
