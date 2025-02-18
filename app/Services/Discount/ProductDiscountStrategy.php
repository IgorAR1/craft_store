<?php

namespace App\Services\Discount;

use App\Contracts\DiscountableContract;
use App\Contracts\DiscountStrategyContract;
use App\Models\Discount;

class ProductDiscountStrategy implements DiscountStrategyContract
{
    public function calculateDiscount(DiscountableContract $model): float
    {
        return 2;
    }
}

