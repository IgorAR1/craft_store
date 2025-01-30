<?php

namespace App\Services;

use App\Enums\OrderStatuses;
use App\Factories\PaymentFactory;
use App\Models\Address;
use App\Models\Order;
use App\Values\OrderData;

class OrderService
{
    public function __construct(private readonly PaymentFactory $paymentFactory)
    {
    }

    public function createOrder(OrderData $orderData): Order
    {
        $order = new Order();

        $address = Address::firstOrCreate((array) $orderData->address);

        $order->address()->associate($address);

        $order->user_id = $orderData->userId;
        $order->shipment_type = $orderData->shipmentType;
        $order->order_status = OrderStatuses::AWAITING->name;

//        $order->payment_type = 'App\Models\\'.$payment['paymentType'];
        $payment_data = $orderData->payment;
        $payment = $this->paymentFactory->createPayments($payment_data->paymentType);
        $payment::findOrFail($payment_data->paymentId)->order()->save($order);
        $order->save();

        $products = $orderData->products;
        $order->products()->attach($products);
        $this->updateAmount($order);
        $order->save();

        return $order;
    }

    public function updateAmount(Order $order):void {
        $order->total_amount = $order->products()->sum('price');
    }
}
