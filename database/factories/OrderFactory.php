<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory{
    protected $model= Order::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array{
        return [
            'user_id' => User::whereHas('role', fn ($q) =>
                $q->where('name', 'customer')
            )->inRandomOrder()->first()->id,

            'payment_method_id' => PaymentMethod::inRandomOrder()->first()->id,

            'total' => 0,
            'status' => $this->faker->randomElement(OrderStatus::cases()),
        ];
    }
}
