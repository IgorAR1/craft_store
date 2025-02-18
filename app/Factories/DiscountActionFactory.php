<?php

namespace App\Factories;


use App\Contracts\DiscountActionContract;
use App\Services\Discount\Actions\CategoryDiscountAction;
use App\Services\Discount\Actions\PercentageDiscountAction;

class DiscountActionFactory
{

    public function make($type): DiscountActionContract
    {
        switch ($type) {
            case 'percentage_action': return new PercentageDiscountAction();
            case 'category_action': return new CategoryDiscountAction();
            default: return new PercentageDiscountAction();
        }
    }
}
