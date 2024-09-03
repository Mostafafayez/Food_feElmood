<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantPhoneNumbersTable extends Migration
{
    public function up()
    {
        Schema::create('restaurant_phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('phone_number');
        
        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurant_phone_numbers');
    }
}
