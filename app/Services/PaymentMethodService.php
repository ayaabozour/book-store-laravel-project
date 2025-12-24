<?php

namespace App\Services;

use App\Models\PaymentMethod;
use Illuminate\Pagination\LengthAwarePaginator;

class PaymentMethodService{
    public function paginate(int $perPage =10):LengthAwarePaginator{
        return PaymentMethod::latest()->paginate($perPage);
    }

    public function create(array $data): PaymentMethod{
        return PaymentMethod::create($data);
    }

    public function delete(PaymentMethod $paymentMethod):void{
        $paymentMethod->delete();
    }

}
