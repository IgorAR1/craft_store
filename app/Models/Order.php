<?php

namespace App\Models;

use App\Contracts\DiscountableContract;
use App\Traits\HasDiscounts;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model implements DiscountableContract
{
    use HasFactory,HasUuids,HasDiscounts;

    protected $guarded = [];
    public function products(){
        return $this->morphToMany(Product::class,'productable');
    }

    public function address(){
        return $this->belongsTo(Address::class,'shipment_address_id','id');
    }

    public function user(){
     $this->belongsTo(User::class);
    }

    public function payment(){
        return $this->morphTo();
    }

    public function getDiscounts(): Collection
    {
        // TODO: Implement getDiscounts() method.
    }

}
