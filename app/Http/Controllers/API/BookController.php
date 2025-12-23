<?php

namespace App\Http\Controllers\API;

use App\DTOs\BookFilterDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\BookService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Throwable;

class BookController extends Controller
{
    use ApiResponse;

    public function __construct(protected BookService $bookService){}

    public function index(Request $request){
        try{
            $filters = BookFilterDTO::fromRequest($request);
            $books = $this->bookService->paginateForUser(
            $request->user(),
            $filters
            );

         return  $this->success(
            BookResource::collection($books),
            'Books fetched successfully'
         );
    }catch(Throwable $e){
        report($e);
        return $this->error(
            'Failed to fetch books',
            config('app.debug') ? $e->getMessage() : null,
            500
        );
    }
    }

    public function store(BookRequest $request){
        try{
            $book = $this->bookService->create(
                $request->validated(),
                $request->user()
            );

            return $this->success(
                new BookResource($book),
                'Book created successfully',
                201,
            );
        }catch(Throwable $e){
            report($e);
            return $this->error(
                'Failed to create a book',
                config('app.debug') ? $e->getMessage() : null,
                500
            );
        }
    }

    public function update(BookRequest $request, Book $book){
        try{
            $updatedBook = $this->bookService->update(
                $book,
                $request->validated()
            );

            return $this->success(
                new BookResource($updatedBook),
                'Book updated successfully'
            );

        }catch(Throwable $e){
            report($e);
            return $this->error(
                'Failed to update the book',
                config('app.debug') ? $e->getMessage() : null,
                500
            );
        }
    }

    public function destroy(Book $book){
        try{
            $this->bookService->delete($book);

            return $this->success(
                null,
                'Book deleted successfully',
            );
        }
        catch(Throwable $e){
            report($e);
            return $this->error(
                'Failed to delete the book',
                config('app.debug') ? $e->getMessage() : null,
                500
            );
        }

    }
}
