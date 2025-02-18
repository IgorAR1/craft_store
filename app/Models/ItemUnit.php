<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemUnit extends Model
{
    /** @use HasFactory<\Database\Factories\ItemUnitFactory> */
    use HasFactory,HasUuids;

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function adjustment()
    {
        return $this->morphToMany(Adjustment::class,'adjustmentable');
    }

    public function getProductPrice(): float
    {
        return $this->item->unit_price;
    }

}
