<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'img' => $this->img_url,
            'quantity' => $this->quantity,
            'color' => $this->color,
            'categories' => $this->whenLoaded('categories',CategoryResource::collection($this->categories))
        ];
    }
}
