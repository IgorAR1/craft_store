<?php

namespace App\Models;

use App\Contracts\DiscountableContract;
use App\Traits\HasDiscounts;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Cart extends Model implements DiscountableContract
{
    use HasFactory,HasUuids,HasDiscounts;

    protected $guarded = [];

    protected $fillable = ['user_id'];

//    public function products() {
//        return $this->belongsToMany(Product::class)->withPivot('quantity');
//    }


    public function product()
    {
        return $this->morphToMany(Product::class,'productable')->withPivot('quantity');
    }

    public function item()
    {
        return $this->morphToMany(Item::class,'itemable');
    }

    public function adjustment()
    {
        return $this->morphToMany(Adjustment::class,'adjustmentable');
    }

    public function getDiscounts(): Collection
    {
        return Discount::query()->where('subject','cart')->orderBy('discount_amount')->get();
    }

    public function getTotalPrice(): float
    {
        return $this->total;
    }

    public function getItems(): Collection
    {
        return $this->item;
    }


}
