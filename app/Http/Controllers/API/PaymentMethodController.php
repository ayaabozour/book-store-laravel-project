<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethodRequest;
use App\Http\Resources\PaymentMethodResource;
use App\Models\PaymentMethod;
use App\Services\PaymentMethodService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Throwable;

class PaymentMethodController extends Controller{
    use ApiResponse;

    public function __construct(
        protected PaymentMethodService $paymentMethodService
    ){}

    public function index(Request $request){
        try{
            $paymentMethods = $this->paymentMethodService->paginate(
                $request->query('per_page',10)
            );

            return $this->success(
                PaymentMethodResource::collection($paymentMethods),
                'Payment methods fetched successfully',
            );
        }
        catch(Throwable $e){
            report($e);
            return $this->error(
                'Failed to fetch payment methods',
                config('app.debug')? $e->getMessage():null,
                500
            );
        }
    }

    public function store (PaymentMethodRequest $request){
        try{
            $paymentMethod = $this->paymentMethodService->create(
                $request->validated()
            );

            return $this->success(
                new PaymentMethodResource($paymentMethod),
                'Payment method created successfully',
                201,
            );
        }
        catch(Throwable $e){
            report($e);
            return $this->error(
                'Failed to create payment method',
                config('app.debug')?$e->getMessage():null,
                500
            );
        }
    }

    public function destroy(PaymentMethod $paymentMethod){
        try{
            $this->paymentMethodService->delete($paymentMethod);

            return $this->success(
                null,
                'Payment method deleted successfully'
            );

        }
        catch(Throwable $e){
            report($e);
            return $this->error(
                'Failed to delete payment method',
                config('app.debug')?$e->getMessage():null,
                500
            );
        }
    }


}
