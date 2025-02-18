<?php

namespace App\Values;

final class PaymentData
{
    public string $paymentId;

    public string $paymentType;

    public function __construct(string $paymentId, string $paymentType)
    {
        $this->paymentId = $paymentId;
        $this->paymentType = $paymentType;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['paymentId'],
            $data['paymentType']
        );
    }
}
