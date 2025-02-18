<?php

namespace App\Services\Discount\Rules;

use App\Contracts\CompositeDiscountCheckerInterface;
use App\Contracts\DiscountableContract;
use App\Contracts\DiscountCheckerInterface;
use App\Models\Discount;

class DiscountCheckerComposite implements CompositeDiscountCheckerInterface
{
    private array $checkers;

    public function __construct(array $checkers)
    {
        $this->checkers = $checkers;
    }

    public function check(DiscountableContract $discountable, Discount $discount): bool
    {
        foreach ($this->checkers as $checker) {
            if (!$checker->check($discountable, $discount)) {
                return false;
            }
        }
        return true;
    }

    public function addChecker(DiscountCheckerInterface $checker): void//В базовый класс
    {
        $this->checkers[] = $checker;
    }

    public function removeChecker(DiscountCheckerInterface $checker): void
    {
        $this->checkers = array_filter($this->checkers, function ($child) use ($checker) {
            return $child !== $checker;
        });
    }

}
