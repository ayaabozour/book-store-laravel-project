<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Exceptions\InsufficientStockException;
use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class OrderService{

    public function create(array $data, $user):Order{
        return DB::transaction(function () use($data, $user) {

            $items = collect($data['items']);

            $books = Book::lockForUpdate()->whereIn('id',$items->pluck('book_id'))->get()->keyBy('id');

            $total = 0;

          foreach($items as $item){
            $book = $books[$item['book_id']];
            if($book->stock < $item['quantity']){
                throw new InsufficientStockException("Insufficient stock for {$book->title}");
            }
            $total+= $book->price * $item['quantity'];
          }

          $order = Order::create([
            'user_id'=>$user->id,
            'payment_method_id'=> $data['payment_method_id'],
            'total'=>$total,
            'status'=>OrderStatus::PENDING,
          ]);

          foreach($items as $item){
            $book= $books[$item['book_id']];
            $order->items()->create([
                'book_id'=>$book->id,
                'quantity'=>$item['quantity'],
                'price'=>$book->price,
            ]);
            $book->decrement('stock',$item['quantity']);
          }

          return $order->load('items.book');
        });
    }

    public function paginateForUser(User $user){
        if($user->role->name === 'author'){
            return Order::whereHas('items.book',fn($q)=>$q->where('author_id',$user->id))->with('items.book')->latest()->paginate();
        }

        return Order::where('user_id',$user->id)->with('items.book')->latest()->paginate();
    }

}
