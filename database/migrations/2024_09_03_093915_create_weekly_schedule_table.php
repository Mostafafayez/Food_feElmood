<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeeklyScheduleTable extends Migration
{
    public function up()
    {
        Schema::create('weekly_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->time('saturday_opening_time')->nullable();
            $table->time('saturday_closing_time')->nullable();
            $table->time('sunday_opening_time')->nullable();
            $table->time('sunday_closing_time')->nullable();
            $table->time('monday_opening_time')->nullable();
            $table->time('monday_closing_time')->nullable();
            $table->time('tuesday_opening_time')->nullable();
            $table->time('tuesday_closing_time')->nullable();
            $table->time('wednesday_opening_time')->nullable();
            $table->time('wednesday_closing_time')->nullable();
            $table->time('thursday_opening_time')->nullable();
            $table->time('thursday_closing_time')->nullable();
           
        });
    }

    public function down()
    {
        Schema::dropIfExists('weekly_schedule');
    }
}
