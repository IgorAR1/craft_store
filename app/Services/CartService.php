<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CartService
{

    public ?User $user;
    // private Cart $cart;

    public function __construct()
    {
        $this->user = Auth::user();
        // $this->cart = $this->resolveCart();
    }

    public function addProductsToCard(Cart $cart ,array $products): Cart{

        return DB::transaction(function() use ($cart,$products){
            foreach($products as $product){
                $this->addProductToCard($cart,$product['product_id'],$product['quantity']);
            }
//            $cart->products()->syncWithoutDetaching($products);

            return $cart;
        });
    }

    public function addProductToCard(Cart $cart, string $product_id,int $quantity = 1): Cart{
        $cart->products()->syncWithoutDetaching([$product_id => ['quantity' => $quantity]]);

        return $cart;
    }


    public function changeProductCount(string $product_id, int $count){

        $cart = $this->getCart();

        // $qty = $this->getCurrentProductQty($cart,$product_id) + $qty;

        $cart->products()->syncWithoutDetaching([$product_id => ['quantity' => $count]]);

        return $cart;
    }

    public function removeProducts(array $product_ids){

        $cart = $this->getCart();

        foreach($product_ids as $product){
            $this->removeProduct($cart,$product);
        }

        return $cart;
    }

    public function removeProduct(Cart $cart, string $product_id){
        // $qty = $this->getCurrentProductQty($cart,$product_id) + $qty;
        $cart->products()->detach($product_id);
    }

    private function resolveCart(): Cart{

        // if ($this->cart){
        //     return $this->cart;
        // }

        if (Cookie::has('csuid'))
        {
            return Cart::query()->findOrFail(Cookie::get('csuid'));//OrFail?
        }

        if ($this->user?->cart){
            return $this->user->cart;
        }

        return $this->createCart();
    }

    public function getCart(): Cart
    {
        return $this->resolveCart();
    }

    public function createCart(): Cart
    {
       return Cart::create([$this->user?->id]);
    }

    // public function getCurrentProductQty(Cart $cart, string $product_id): int{
    //     $product = $cart->products()
    //         ->where('product_id',$product_id)
    //         ->first();
    //     if($product){
    //         return $product->pivot->quantity;
    //     }
    //     return 0;
    // }

}
