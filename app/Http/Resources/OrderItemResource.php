<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'book' => [
                'id' => $this->book->id,
                'title' => $this->book->title,
            ],
            'quantity' => $this->quantity,
            'price' => $this->price,
        ];
    }
}
