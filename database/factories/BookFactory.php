<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'title'=> $this->faker->sentence(3),
           'description'=> $this->faker->paragraph(),
           'price'=> $this->faker->randomFloat(3,5,100),
           'stock'=> $this->faker->numberBetween(0,50),
           'category_id'=> Category::inRandomOrder()->first()->id,
           'author_id'=>User::whereHas('role', fn($q)=> $q->where('name','author'))->inRandomOrder()->first()->id,
        ];
    }
}
