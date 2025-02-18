<?php

namespace App\Models;

use App\Contracts\DiscountableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function discount(): MorphToMany
    {
        return $this->morphToMany(Discount::class,'discountables');
    }
}
