<?php

namespace App\Contracts;

use App\Models\Discount;

interface DiscountCheckerInterface
{
    public function check(DiscountableContract $discountable, Discount $discount): bool;
}
