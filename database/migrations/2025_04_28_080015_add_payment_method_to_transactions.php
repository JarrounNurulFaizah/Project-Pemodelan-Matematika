<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentMethodToTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Menambahkan kolom payment_method
            $table->string('payment_method')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Menghapus kolom payment_method
            $table->dropColumn('payment_method');
        });
    }
}
