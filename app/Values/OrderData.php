<?php

namespace App\Values;

use App\Enums\OrderStatuses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class OrderData
{
    public AddressData $address;

    public PaymentData $payment;

    public array $products;

    public string $userId;

    public ?string $orderStatus = null;

    public string $shipmentType;

    public function __construct(
        AddressData $address,
        PaymentData $payment,
        array $products,
        string $userId,
        string $shipmentType,
        string $orderStatus = null,
    )
    {
        $this->address = $address;
        $this->payment = $payment;
        $this->products = $products;
        $this->userId = $userId;
        $this->shipmentType = $shipmentType;
        $this->orderStatus = $orderStatus;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            address: AddressData::fromArray($data['deliveryAddress']),
            payment: PaymentData::fromArray($data['payment']),
            products: $data['products'],
            userId: Auth::id(),
            shipmentType: $data['deliveryType'],
            orderStatus: $data['orderStatus'] ?? null
        );
    }
    public static function fromRequest(Request $request): self
    {
        $data = $request->all();

        return self::fromArray($data);
    }
}
