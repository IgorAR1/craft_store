<?php

namespace App\Traits;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasDiscounts
{

    public function discount(): MorphToMany
    {
        return $this->morphToMany(Discount::class,'discountables');
    }

    public function getTotalPrice(): float
    {
        return $this->price;
    }
}
