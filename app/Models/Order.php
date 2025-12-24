<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'payment_method_id',
        'total',
        'status'
    ];

    protected $casts = [
        'status'=>OrderStatus::class,
    ];

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function customer(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
