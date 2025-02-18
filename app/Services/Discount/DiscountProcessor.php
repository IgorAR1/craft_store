<?php

namespace App\Services\Discount;

use App\Contracts\DiscountableContract;
use App\Contracts\DiscountCheckerInterface;
use App\Models\Discount;
use App\Services\Discount\Actions\ActionApplicator;

class DiscountProcessor
{
    public function __construct(readonly DiscountCheckerInterface $checker,
                                readonly ActionApplicator         $actionApplicator
    )
    {
    }

    public function process(DiscountableContract $model): void
    {
        $discounts = $model->getDiscounts();

        $discounts->each(function (Discount $discount) use ($model) {
            if ($this->checker->check($model, $discount)) {
                $this->actionApplicator->apply($model, $discount);
            }
        });
    }

}
