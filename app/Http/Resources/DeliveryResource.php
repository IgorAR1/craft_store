<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'address_id' => $this->id,
            'address' => $this->address,
            'country' =>  $this-> country,
            'region' => $this->region,
            'city' => $this-> city,
            'district' => $this->district ,
            'street' => $this->street ,
            'building' => $this->building ,
            'floor' => $this->floor,
            'apartment_number' => $this->apartment_number,
        ];
    }
}
