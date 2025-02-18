<?php

namespace App\Services\Discount\Rules;

use App\Contracts\DiscountableContract;
use App\Contracts\DiscountRules;

class wwDiscountRule implements DiscountRules
{
//    public function handle(DiscountableContract $model, \Closure $next): bool
//    {
//        dump('22');
//        return $next($model);
//    }

    public function execute(DiscountableContract $model): bool
    {
        dump('22');
        return true;
    }
}
