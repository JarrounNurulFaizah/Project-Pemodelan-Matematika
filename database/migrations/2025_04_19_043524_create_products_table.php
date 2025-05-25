<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key otomatis
            $table->string('name'); // Nama produk
            $table->integer('price'); // Harga produk
            $table->string('picture')->nullable(); // Gambar produk (opsional)
            $table->text('description')->nullable(); // Deskripsi produk (opsional)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
