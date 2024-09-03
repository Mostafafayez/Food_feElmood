<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchPhoneNumbersTable extends Migration
{
    public function up()
    {
        Schema::create('branch_phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->string('phone_number');

        });
    }

    public function down()
    {
        Schema::dropIfExists('branch_phone_numbers');
    }
}
