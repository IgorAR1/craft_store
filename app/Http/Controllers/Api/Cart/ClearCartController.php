<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Services\Cart\CartService;

class ClearCartController extends Controller
{

    public function __construct(public readonly CartService $service)
    {}

    public function __invoke(){
        $this->service->getCart()->product()->sync([]);//или getCart()->delete():/
        return response('true',204);
    }

}
