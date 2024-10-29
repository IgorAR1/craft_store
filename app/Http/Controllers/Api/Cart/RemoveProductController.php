<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\RemoveFromCartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class RemoveProductController extends Controller
{
  public function __construct(public readonly CartService $service)
  {}

  public function __invoke(RemoveFromCartRequest $request){

    $this->service->removeProducts($request->product_ids);

    return response('',204);
  }

}
