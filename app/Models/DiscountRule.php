<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountRule extends Model
{
    //
    public function getType(): string
    {
        return $this->type;
    }
}
