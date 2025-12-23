<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return $this->error(
                    'Invalid credentials',
                    401
                );
            }

            $token = $user->createToken('api-token')->plainTextToken;

            $user->token = $token;

            return $this->success(
                new LoginResource($user),
                'Logged in successfully'
            );

        } catch (Throwable $e) {

            report($e);

            return $this->error(
                'Login failed',
                config('app.debug') ? $e->getMessage() : null,
                500
            );
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            if (! $user || ! $user->currentAccessToken()) {
                return $this->error(
                    'Unauthenticated',
                    401
                );
            }

            $user->currentAccessToken()->delete();

            return $this->success(
                null,
                'Logged out successfully'
            );

        } catch (Throwable $e) {

            report($e);

            return $this->error(
                'Logout failed',
                config('app.debug') ? $e->getMessage() : null,
                500
            );
        }
    }
}
