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
            $table->decimal('cost', 8, 2)->nullable();
            $table->enum('status', ['pending', 'recommend'])->default('pending');
            $table->foreignId('food_id')->constrained('SpinerFood')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
