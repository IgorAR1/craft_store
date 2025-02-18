<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory,HasUuids;

    protected $guarded = [];

    public function unit(): HasMany
    {
        return $this->hasMany(ItemUnit::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getUnits(): Collection
    {
        return $this->unit()->get();
    }

    public function adjustment()
    {
        return $this->morphToMany(Adjustment::class,'adjustmentable');
    }

    public static function getByProductId(string $product_id): ?Item
    {
        return Item::query()->where('product_id',$product_id)->first();
    }

}
