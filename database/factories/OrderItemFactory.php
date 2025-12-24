<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory{
    protected $model= OrderItem::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array{
        $book = Book::inRandomOrder()->first();

        return [
            'book_id' => $book->id,
            'quantity' => $qty = $this->faker->numberBetween(1, 3),
            'price' => $book->price,
        ];
    }
}
