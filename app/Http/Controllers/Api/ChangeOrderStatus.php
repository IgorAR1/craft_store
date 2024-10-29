<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Symfony\Component\HttpFoundation\Request;

class ChangeOrderStatus
{
    public function __invoke(Request $request,Order $order){

        $request->validate(['status' => ['required']]);

        $order->update(['order_status' => $request->status]);

        return new OrderResource($order);

    }
}
