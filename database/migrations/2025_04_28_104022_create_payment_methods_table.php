<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // misal: BNI, BCA, Mandiri
            $table->string('description')->nullable(); // opsional deskripsi
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}
