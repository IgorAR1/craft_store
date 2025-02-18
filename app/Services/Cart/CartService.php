<?php

namespace App\Services\Cart;

use App\Factories\CartFactory;
use App\Factories\ItemUnitsFactory;
use App\Models\Adjustment;
use App\Models\Cart;
use App\Models\User;
use App\Services\Discount\DiscountProcessor;
use App\Services\ItemService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CartService
{
    public ?User $user;

    // private Cart $cart;

    public function __construct(readonly ItemUnitsFactory  $itemUnitsFactory,
                                readonly CartFactory       $cartFactory,
                                readonly DiscountProcessor $discountProcessor,
                                readonly ItemService       $itemService,
    )
    {
        $this->user = Auth::user();
    }

    public function addItemsToCart(Cart $cart, array $products): Cart
    {
        return DB::transaction(function () use ($cart, $products) {
            foreach ($products as $product) {
                $this->addItemToCart($cart, $product['product_id'], $product['quantity']);
            }

            $this->processCart($cart);

            return $cart;
        });
    }
//Удаление и добавление в корзину - все через addItemToCart
//Сделать проверку на qty <= maxQty
    public function addItemToCart(Cart $cart, string $product_id, int $quantity = 1): Cart
    {
        $item = $cart->item()->where('product_id', $product_id)->first();

        if ($item) {
            $this->itemService->updateItem($item, $quantity);
        } else {
            $item = $this->itemService->createItem($item, $quantity);
        }

        $cart->item()->syncWithoutDetaching($item);
//        $this->recalculateTotal($cart);

        return $cart;
    }

    public function resetCart(Cart $cart)
    {
        //
    }

    private function resolveCart(): Cart
    {

        if (Cookie::has('csuid') && Cart::query()->find(Cookie::get('csuid')))//Чистить куки при логауте!!!
        {
            return Cart::query()->find(Cookie::get('csuid'));
        }

        if ($this->user?->cart) {
            return $this->user->cart;
        }

        return Cart::query()->create(['user_id' => $this->user?->id]);
    }

    public function getCart(): Cart
    {
        return $this->resolveCart();
    }

    //Способ номер один - прямое использование классов обработичиков - плохо расширяемый, но может быть достаточный в рамках задачи
    private function processCart(Cart $cart): void//Это команда
    {
        $this->discountProcessor->process($cart);

        $this->recalculateTotal($cart);
    }

    public function recalculateTotal(Cart $cart): void
    {
        foreach ($cart->getItems() as $item) {
            $this->itemService->recalculateTotal($item);
        }
        $cart->total_price = $cart->item()->sum('total_price');
        $this->recalculateAdjustment($cart);
        $cart->discounted_price = $cart->total_price - $cart->adjustments_total;

        $cart->save();
    }

    public function recalculateAdjustment(Cart $cart): void
    {
        $sum = $cart->adjustment()->sum('amount');
        $cart->adjustments_total = $sum;

        $cart->save();
    }

    public function addAdjustment(Cart $cart, Adjustment $adjustment): void
    {
        $cart->adjustment()->save($adjustment);
        $this->recalculateAdjustment($cart);
    }
    //Способ номер два,расширяемый ОО подход
//    private function processCart(Cart $cart): void//Это команда
//    {
//       $processor = $this->processorFactory->create();
//
//       $processor->execute($cart);
//
//    }


}
