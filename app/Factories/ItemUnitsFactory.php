<?php

namespace App\Factories;

use App\Models\Item;
use App\Models\ItemUnit;

class ItemUnitsFactory
{
    public function makeForItem(Item $item): ItemUnit
    {
        $unit = new ItemUnit();
        $unit->item_id = $item->id;
        $unit->total_price = $item->product?->getTotalPrice();

        return $unit;
    }
}
