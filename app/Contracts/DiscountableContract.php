<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface DiscountableContract
{
    public function getTotalPrice(): float;
    public function discount(): MorphToMany;//Это как бы и не нужно
    public function getDiscounts():Collection;
}
