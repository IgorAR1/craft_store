<?php

namespace App\Contracts;

interface DiscountRules
{
//    public function handle(DiscountableContract $model,\Closure $next): bool;
    public function execute(DiscountableContract $model): bool;
}
