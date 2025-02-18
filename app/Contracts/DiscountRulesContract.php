<?php

namespace App\Contracts;

interface DiscountRulesContract
{
    public function isAcceptably(DiscountableContract $model): bool;
}
