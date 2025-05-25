<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'picture', // Pastikan kolom ini ada di tabel products jika digunakan
    ];

    /**
     * Relasi: Produk ini bisa muncul di banyak detail transaksi.
     */
    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
