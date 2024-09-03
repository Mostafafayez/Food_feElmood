<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantUrlsTable extends Migration
{
    public function up()
    {
        Schema::create('restaurant_urls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('facebook_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('whatsapp_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('tiktok_url')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurant_urls');
    }
}

