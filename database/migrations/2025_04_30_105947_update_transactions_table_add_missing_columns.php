<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTransactionsTableAddMissingColumns extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('transaction_number')->unique()->after('customer_id');
            $table->unsignedBigInteger('payment_method_id')->nullable()->after('transaction_number');
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('transaction_number');
            $table->dropColumn('payment_method_id');
        });
    }
}
