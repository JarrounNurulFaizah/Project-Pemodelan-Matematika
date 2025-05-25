<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        $methods = [
            ['name' => 'BNI', 'description' => 'Bank Negara Indonesia'],
            ['name' => 'BCA', 'description' => 'Bank Central Asia'],
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}
