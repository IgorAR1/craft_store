<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Resources\CartProductResource;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Services\CartService;
use Symfony\Component\HttpFoundation\Response;


class AddToCartController extends Controller
{

    public function __construct(public readonly CartService $service)
    {}

    public function __invoke(AddToCartRequest $request): Response{

        $data = $request->validated();

        $cart = $this->service->getCart();

        $cart = $this->service->addProductsToCard($cart ,$data['products']);

        return response(new CartResource($cart))->withCookie(cookie('csuid',$cart->id));
    }
}
