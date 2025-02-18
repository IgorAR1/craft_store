<?php

namespace App\Enums;

enum ActionType :string
{
    case CREATED = 'created';
    case EDITED = 'edited';
    case DELETED = 'deleted';
}
