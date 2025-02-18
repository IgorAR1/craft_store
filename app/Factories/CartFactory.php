<?php

namespace App\Factories;

use App\Models\Cart;

class CartFactory
{

    public function createForUser(?string $userId)
    {
        return Cart::create([$userId]);//В фабрику
    }
}
