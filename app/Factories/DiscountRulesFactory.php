<?php

namespace App\Factories;

use App\Contracts\CategoryDiscountRule;
use App\Contracts\wwDiscountRule;

class DiscountRulesFactory
{

    public function make($type)
    {
        switch ($type) {
            case 'percentage_rule': return new wwDiscountRule();
            case 'category_rule': return new CategoryDiscountRule();
            default: break;
        }
    }
}
