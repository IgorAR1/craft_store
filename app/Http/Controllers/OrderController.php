<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatuses;
use App\Factories\PaymentFactory;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Address;
use App\Models\Order;
use App\Services\CartService;
use App\Services\OrderService;
use App\Values\OrderData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OrderResource::collection(Order::all());
    }

    public function __construct(public readonly PaymentFactory $paymentFactory,
                                public readonly OrderService $orderService)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrderRequest $request): JsonResource
    {
        $orderData = OrderData::fromRequest($request);

        $order = $this->orderService->createOrder($orderData);

//        $data = $request->validated();

//        $order = new Order();
//
//        $addressData = $data['deliveryAddress'];
//        $address = $order->address()->firstOrCreate([
//                'country' => $addressData['country'],
//                'region' => $addressData['region'],
//                'city' => $addressData['city'],
//                'district' => $addressData['district'],
//                'street' => $addressData['street'],
//                'building' => $addressData['building'],
//                'floor' => $addressData['floor'] ?? null,
//                'apartment_number' => $addressData['apartment_number'] ?? null,
//            ]);
//
//        $order->address()->associate($address);
//
//        $order->user_id = Auth::id();
////        $order->shipment_address_id = $address->id;
//        $order->order_status = OrderStatuses::AWAITING->name;//Полная хуйня, закинуть сия конструкцию в дефолт миграции
//        $order->shipment_type = $data['deliveryType'];
////        $order->payment_type = 'App\Models\\'.$payment['paymentType'];
////        $order->payment_type = ((new PaymentFactory())->createPayments($payment_data['paymentType']));
////        $order->payment_id = $payment_data['paymentId'];
//        $payment_data = $data['payment'];
//        $payment = $this->paymentFactory->createPayments($payment_data['paymentType']);
//        $payment::findOrFail($payment_data['paymentId'])->order()->save($order);
//        $order->save();
//
//        $products = $data['products'];
//        $order->products()->attach($products);
//        $this->updateAmount($order);

//        $address = new Address();
//        $address->country = $addressData['country'];
//        $address->region = $addressData['region'];
//        $address->city = $addressData['city'];
//        $address->district = $addressData['district'];
//        $address->street = $addressData['street'];
//        $address->building = $addressData['building'];
//        $address->floor = $addressData['floor'] ?? null;
//        $address->apartment_number = $addressData['apartment_number'] ?? null;
//        $address->save();
        return new OrderResource($order);
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response(null, 204);
    }
}
