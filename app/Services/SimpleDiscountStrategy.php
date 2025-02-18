<?php

namespace App\Services;

use App\Contracts\DiscountableContract;
use App\Contracts\DiscountStrategyContract;
use App\Models\Discount;

class SimpleDiscountStrategy implements DiscountStrategyContract
{
    public function calculateDiscount(DiscountableContract $model,Discount $discount): float
    {
        $price = $model->getTotalPrice();

        if ($discount->isFixed()){
            return $price - $discount->amount;
        }

       return $price - ($price * $discount->amount)/100;
    }
}
