<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantMenusTable extends Migration
{
    public function up()
    {
        Schema::create('restaurant_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('menu_image');

        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurant_menus');
    }
}
