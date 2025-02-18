<?php

namespace App\Contracts;

use App\Models\Discount;

interface DiscountActionContract
{
    public function execute(DiscountableContract $model): void;
}
