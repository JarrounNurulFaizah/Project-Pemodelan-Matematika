<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Relasi: Satu metode pembayaran digunakan di banyak transaksi.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
