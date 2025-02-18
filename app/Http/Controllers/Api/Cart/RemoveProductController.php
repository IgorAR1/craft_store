<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\RemoveFromCartRequest;
use App\Services\Cart\CartService;

class RemoveProductController extends Controller
{
  public function __construct(public readonly CartService $service)
  {}

  public function __invoke(RemoveFromCartRequest $request){

    $this->service->removeItems($request->product_ids);

    return response('',204);
  }

}
