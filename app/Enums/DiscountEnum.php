<?php

namespace App\Enums;

enum DiscountEnum :int
{
    case SIMPLE = 0;
    case FREE_SHIPPING = 1;
    case NEXT_PURCHASE = 2;
    case CATEGORY = 3;
    case BUNDLE = 4;
    case PERSONAL = 5;
}
