<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    public function up()
{
    Schema::create('customers', function (Blueprint $table) {
        $table->id();
        $table->string('name_institution');
        $table->string('email')->unique();
        $table->string('phone');
        $table->string('address');
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
