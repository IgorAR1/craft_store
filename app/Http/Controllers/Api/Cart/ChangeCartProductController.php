<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeCartProductRequest;
use App\Http\Resources\CartResource;
use App\Models\Product;
use App\Services\Cart\CartService;

class ChangeCartProductController extends Controller
{
    public function __construct(public readonly CartService $service)
    {}

    public function __invoke(ChangeCartProductRequest $request,Product $product){//можно и просто uid передавать string $product_id

        $data = $request->validated();
        $cart = $this->service->getCart();

        // CartProduct::where('cart_id',$cart->id)->where('product_id',$product->id)->update(['quantity'=>$data['quantity']]);

        // $product->cart()->updateExistingPivot($cart->id,['quantity' => $data['quantity']]);
        $cart->product()->updateExistingPivot($product->id, ['quantity' => $data['quantity']]);

        // $products = $cart->products();

        // foreach($data['products'] as $product){
        //     $products->updateExistingPivot($product['product_id'],['quantity' => $product['quantity']]);
        // }
        return new CartResource($cart);
    }
}
