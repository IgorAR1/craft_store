<?php

namespace App\Contracts;

use App\Models\Discount;

interface DiscountStrategyContract
{
    public function calculateDiscount(DiscountableContract $model): float;
}
