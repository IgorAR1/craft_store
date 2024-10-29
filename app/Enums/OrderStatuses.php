<?php

namespace App\Enums;

enum OrderStatuses {
    case AWAITING;
    case Processing;
    case Shipping;
    case Completed;
    case Declined;
}
