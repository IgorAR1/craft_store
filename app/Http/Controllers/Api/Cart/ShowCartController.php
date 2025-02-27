<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Services\CartService;

class ShowCartController extends Controller
{
    public function __construct(public readonly CartService $service)
    {

    }

    public function __invoke(){

        $cart = $this->service->getCart();

        return response(new CartResource($cart->load('products')))->withCookie(cookie('csuid',$cart->id));
    }
}
