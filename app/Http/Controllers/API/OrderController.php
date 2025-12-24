<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Throwable;

class OrderController extends Controller{
    use ApiResponse;

    public function __construct(
        protected OrderService $orderService
    ){}

    public function index(Request $request){
        try{
            $orders = $this->orderService->paginateForUser($request->user());

            return $this->success(
               OrderResource::collection($orders),
               'Orders fetched successfully'
            );
        }
        catch(Throwable $e){
            report($e);

            return $this->error(
                'Failed to fetch orders',
                config('app.debug')?$e->getMessage():null,
                500
            );
        }
    }

    public function store(OrderRequest $request){
        try{
            $order = $this->orderService->create(
                $request->validated(),
                $request->user()
            );

            return $this->success(
                new OrderResource($order),
                'Order created successfully',
                201
            );
        }
        catch(Throwable $e){
            report($e);

            return $this->error('Failed to create an order',
        config('app.debug')?$e->getMessage():null,
        400
        );
        }
    }

}
