<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BookOwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next){
        $book = $request->route('book');

        if ($request->user()->role->name === 'admin') {
            return $next($request);
        }

        if ($book->author_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        return $next($request);
    }
}
