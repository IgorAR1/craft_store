<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory,HasUuids;

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
}
