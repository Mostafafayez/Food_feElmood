<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpinerFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spiner_food', function (Blueprint $table) {
            $table->id();  // Adds an auto-incrementing unsigned big integer primary key
            $table->string('food_type');  // Adds a 'food_type' column of type VARCHAR
            $table->integer('priority');  // Adds a 'priority' column of type INTEGER
            $table->enum('status', ['false', 'true'])->default('false');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spiner_food');
    }
}
