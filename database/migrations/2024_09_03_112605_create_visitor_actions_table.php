<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorActionsTable extends Migration
{
    public function up()
    {
        Schema::create('visitor_actions', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip_address');
            $table->string('action');
            $table->foreignId('restaurant_id')->nullable()->constrained()->onDelete('set null');
   
        });
    }

    public function down()
    {
        Schema::dropIfExists('visitor_actions');
    }
}
