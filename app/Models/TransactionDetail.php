<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetail extends Model
{
    use HasFactory;

    /**
     * Kolom-kolom yang dapat diisi massal.
     */
    protected $fillable = [
        'transaction_id',
        'product_id',
        'item_name',
        'quantity',
        'price',
        'subtotal',
    ];

    /**
     * Relasi ke transaksi induk.
     * Setiap detail transaksi dimiliki oleh satu transaksi.
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Relasi ke produk.
     * Setiap detail transaksi berhubungan dengan satu produk.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
