<?php

namespace App\Contracts;

interface CompositeDiscountCheckerInterface extends DiscountCheckerInterface
{

    public function addChecker(DiscountCheckerInterface $checker);
    public function removeChecker(DiscountCheckerInterface $checker);
}
