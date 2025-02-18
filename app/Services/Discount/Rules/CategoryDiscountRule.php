<?php

namespace App\Services\Discount\Rules;

use App\Contracts\DiscountableContract;
use App\Contracts\DiscountRules;

class CategoryDiscountRule implements DiscountRules
{
    public function execute(DiscountableContract $model): bool
    {
        dump('11');
        return true;
    }
}
