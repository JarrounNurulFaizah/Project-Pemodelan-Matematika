<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $guard = 'customer';

    /**
     * Kolom yang dapat diisi secara mass-assignment.
     */
    protected $fillable = [
        'name_institution',
        'email',
        'phone',
        'address',
        'phone_number',
        'password',
    ];

    /**
     * Kolom yang disembunyikan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi: Customer memiliki banyak transaksi.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
