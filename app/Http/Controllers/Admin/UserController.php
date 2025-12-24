<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller
{
    use ApiResponse;

    public function __construct(
        private UserService $userService
    ) {}

    public function authors(Request $request){
        try {
            $authors = $this->userService->listByRole('author', $request);

            return $this->success(
                UserResource::collection($authors),
                'Authors fetched successfully'
            );
        } catch (Throwable $e) {
            report($e);

            return $this->error(
                'Failed to fetch authors',
                config('app.debug') ? $e->getMessage() : null,
                500
            );
        }
    }

    public function customers(Request $request){
        try {
            $customers = $this->userService->listByRole('customer', $request);

            return $this->success(
                UserResource::collection($customers),
                'Customers fetched successfully'
            );
        } catch (Throwable $e) {
            report($e);

            return $this->error(
                'Failed to fetch customers',
                config('app.debug') ? $e->getMessage() : null,
                500
            );
        }
    }
}
