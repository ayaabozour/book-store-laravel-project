<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'price',
        'stock',
        'category_id',
        'author_id',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function author(){
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopeSearchTitle($query, ?string $search){
        if(!$search){
            return $query;
        }
       return $query->where('title','LIKE',"%{$search}%");
    }

    public function scopeFilterCategory($query, ?int $categoryId){
        if(!$categoryId){
            return $query;
        }
        $query->where('category_id',$categoryId);
    }

    public function scopeSearchAuthor($query, ?string $author){
        if ($author) {
            $query->whereHas('author', function ($q) use ($author) {
                $q->where('name', 'LIKE', "%{$author}%");
            });
        }
        return $query;
    }



}
