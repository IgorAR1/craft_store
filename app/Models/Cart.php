<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory,HasUuids;

    protected $guarded = [];

    protected $fillable = ['user_id'];

//    public function products() {
//        return $this->belongsToMany(Product::class)->withPivot('quantity');
//    }

    public function products() {
        return $this->morphToMany(Product::class,'productable')->withPivot('quantity');
    }
}
