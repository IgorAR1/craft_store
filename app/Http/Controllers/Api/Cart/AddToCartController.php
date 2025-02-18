<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Resources\CartResource;
use App\Services\Cart\CartService;
use Symfony\Component\HttpFoundation\Response;


class AddToCartController extends Controller
{

    public function __construct(public readonly CartService $service)
    {}

    public function __invoke(AddToCartRequest $request): Response
    {
        $data = $request->validated();

        $cart = $this->service->getCart();

        $cart = $this->service->addItemsToCart($cart ,$data['products']);

        return response(new CartResource($cart))->withCookie(cookie('csuid',$cart->id));
    }
}
