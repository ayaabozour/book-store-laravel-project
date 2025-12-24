<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        Order::factory()->count(20)->create()->each(function(Order $order){
            $books = Book::inRandomOrder()->take(rand(1,4))->get();

            $total= 0;

            foreach ($books as $book) {
                    $qty = rand(1, min(3, $book->stock));

                    if ($qty <= 0) {
                        continue;
                    }

                    OrderItem::create([
                        'order_id' => $order->id,
                        'book_id' => $book->id,
                        'quantity' => $qty,
                        'price' => $book->price,
                    ]);

                    $book->decrement('stock', $qty);

                    $total += $book->price * $qty;
                }

                $order->update([
                    'total' => $total,
                ]);
        });
    }
}
