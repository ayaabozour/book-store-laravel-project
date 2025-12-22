<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next){
         /** @var User|null $user */
         $user = Auth::user();

         if(!$user){
            return response()->json(
                [
                    'message'=> 'Unauthenticated'
                ],401
            );
         }

        return $next($request);
    }
}
