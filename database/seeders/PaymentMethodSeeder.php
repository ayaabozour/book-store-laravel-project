<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        PaymentMethod::insert(
            [
                [
                    'name'=> 'Cash',
                    'code'=>'cash',
                ],
                [
                    'name'=>'PayPal',
                    'code'=>'paypal',
                ],
                [
                    'name'=>'Credit Card',
                    'code'=>'credit_card',
                ],
            ]
        );
    }
}
