<?php

namespace App\Services\Discount\Actions;

use App\Contracts\DiscountableContract;
use App\Contracts\DiscountActionContract;

class PercentageDiscountAction implements DiscountActionContract
{
    public function execute(DiscountableContract $model): void
    {
        dump('action1');
    }
}
