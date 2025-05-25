<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdToTransactionDetailsTable extends Migration
{
    public function up()
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->after('transaction_id');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });
    }
}
