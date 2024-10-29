<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'addresses';

    public function address():Attribute{
       return Attribute::make(
           get: fn() => implode(', ', array_filter([
               $this->country,
               $this->region,
               $this->city,
               $this->district,
               $this->street,
               $this->building,
               $this->floor,
               $this->apartment_number,
           ]))
        );
    }

}
