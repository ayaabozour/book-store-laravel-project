<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller{
    public function login(LoginRequest $request){
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(
                [
                    'message'=>'Invalid credentials'
                ], 401
            );
        }

        $token = $user->createToken('api-token')->plainTextToken;

        $user->token = $token;

        return new LoginResource($user);
    }

    public function logout(Request $request){
        $user = $request->user();

        if($user && $user->currentAccessToken()){
            $user->currentAccessToken()->delete();
        }

        return response()->json(
            [
                'message'=> 'Logged out successfully',
            ]
        );
    }
}
