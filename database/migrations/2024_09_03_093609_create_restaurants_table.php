<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();  // creates an unsignedBigInteger by default
            $table->string('name');
            $table->string('name_ar')->nullable();  // Added 'name_ar' as per fillable
            $table->string('main_image')->nullable();
            $table->string('thumbnail_image')->nullable(); // Added 'thumbnail_image' as per fillable
            $table->text('review')->nullable();
            $table->text('review_ar')->nullable();  // Added 'review_ar' as per fillable
            $table->text('location')->nullable();
            $table->text('location_ar')->nullable();  // Added 'location_ar' as per fillable
            $table->string('area')->nullable();  // Added 'area' as per fillable
            $table->string('area_ar')->nullable();  // Added 'area_ar' as per fillable
            $table->enum('status', ['pending', 'recommend'])->default('pending');
            $table->string('route')->nullable();  // Added 'route' as per fillable
            $table->string('route_ar')->nullable();  // Added 'route_ar' as per fillable
            $table->decimal('value', 8, 2)->nullable();  // Added 'value' as per fillable
            $table->decimal('cost', 8, 2)->nullable();

            // Add foreign key to 'food_id' that references the 'id' in 'SpinerFood'
            $table->foreignId('food_id')->constrained('SpinerFood')->onDelete('cascade');


            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }




    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
