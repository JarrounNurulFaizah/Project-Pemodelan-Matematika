<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $fillable = [
        'customer_id',
        'transaction_number',
        'total',
        'ppn',
        'grand_total',
        'status',
        'payment_method_id',
        'proof_of_payment',
    ];

    /**
     * Relasi ke customer.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relasi ke user (jika digunakan).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke agency (jika digunakan).
     */
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * Relasi ke metode pembayaran.
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Relasi ke detail transaksi.
     * Dipanggil dengan: $transaction->details
     */
    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Alias relasi ke detail transaksi.
     * Dipanggil dengan: $transaction->transactionDetails
     */
    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
