<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $guarded = [];
    protected $table = 'discounts';

    public function isFixed():bool
    {
        return $this->isFixed;
    }

    public function action()
    {
        return $this->morphedByMany(DiscountAction::class, 'discountables');
    }

    public function rule()
    {
        return $this->morphedByMany(DiscountRule::class, 'discountables');
    }
    public function getActions()
    {
        return $this->morphedByMany(DiscountAction::class, 'discountables')->pluck('type')->toArray();
    }

    public function getRules(): array
    {
        return $this->morphedByMany(DiscountRule::class, 'discountables')->get();
    }
}
