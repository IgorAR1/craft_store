<?php

namespace App\Http\Resources;

use App\Enums\OrderStatuses;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_id' => $this->id,
            'status' => $this->order_status,
            'deliveryAddress' => new DeliveryResource($this->address),
            'deliveryType' => $this->shipment_type,
            'products'=> ProductResource::collection($this->products),
            'amount' => $this->total_amount,
            'payment' => $this->payment
        ];
    }
}
