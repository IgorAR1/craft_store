<?php

namespace App\Factories;

use App\Models\BankingCard;

class PaymentFactory
{
    public function createPayments(string $payment_type){
        switch ($payment_type){
            case 'card':
                return BankingCard::class;
//            default:
//                return BankingCard::class;
        }
    }
}
