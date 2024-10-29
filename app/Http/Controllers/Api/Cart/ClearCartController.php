<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class ClearCartController extends Controller
{

    public function __construct(public readonly CartService $service)
    {}

    public function __invoke(){
        $this->service->getCart()->products()->sync([]);//или getCart()->delete():/
        return response('true',204);
    }

}
