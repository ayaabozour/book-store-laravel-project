<?php

namespace App\Services;

use App\DTOs\BookFilterDTO;
use App\Models\Book;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookService{
    public function paginateForUser(User $user, BookFilterDTO $filters): LengthAwarePaginator{
        $query = Book::query()->with(['category','author'])->searchTitle($filters->search)->filterCategory($filters->categoryId);

        if($user->role->name === 'admin'){
            $query->searchAuthor($filters->author);
        }

        if($user->role->name === 'author'){
            $query->where('author_id',$user->id);
        }

        return $query->latest()->paginate($filters->perPage);
    }

    public function create(array $data, User $author):Book{
        return Book::create([
            ...$data,
            'author_id'=>$author->id,
        ]);
    }

    public function update(Book $book, array $data): Book{
        $book->update($data);
        return $book;
    }

    public function delete(Book $book):void{
        $book->delete();
    }
}
