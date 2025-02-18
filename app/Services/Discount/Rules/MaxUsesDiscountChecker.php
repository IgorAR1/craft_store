<?php

namespace App\Services\Discount\Rules;

use App\Contracts\DiscountableContract;
use App\Contracts\DiscountCheckerInterface;
use App\Models\Discount;

class MaxUsesDiscountChecker implements DiscountCheckerInterface
{

    public function check(DiscountableContract $discountable, Discount $discount): bool
    {
        if (null != $discount->max_uses) {
            return $discount->max_uses >= $discount->uses;
        }

        return true;
    }
}

