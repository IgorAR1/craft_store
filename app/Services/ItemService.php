<?php

namespace App\Services;

use App\Models\Adjustment;
use App\Models\Item;
use App\Models\ItemUnit;

class ItemService
{
    public function __construct(readonly ItemUnitService $unitService)
    {
    }

    public function createItem($quantity, string $product_id): Item
    {
        $item = new Item();

        $item->product_id = $product_id;
        $item->quantity = $quantity;
        $item->unit_price = $item->product->price;
//        $item->recalculateTotal()?
        $item->save();

        $this->createItemUnits($item, $quantity);
        $this->recalculateTotal($item);

        return $item;
    }

    public function updateItem(Item $item, float $quantity): void
    {
        $item->update(['quantity' => $quantity]);
        $item->unit()->delete();
        $this->createItemUnits($item, $quantity);
    }

    private function createItemUnits(Item $item, float $quantity): void
    {
        for ($i = 0; $i < $quantity; ++$i) {
            $this->createItemUnit($item);
        }
    }

    private function createItemUnit(Item $item): void
    {
        $unit = new ItemUnit();
        $unit->item_id = $item->id;
        $item->unit()->save($unit);
    }

    public function recalculateTotal(Item $item): void
    {
        foreach ($item->getUnits() as $unit) {
            $this->unitService->recalculateTotal($unit);
        }

        $item->total_price = $item->unit_price * $item->quantity;
        $item->discounted_price = $item->unit()->sum('total_price') - $item->adjustments_total;

        $item->save();
    }

    public function recalculateAdjustment(Item $item): void
    {
        $item->adjustments_total = $item->adjustment()->sum('amount');
        $item->save();
    }

    public function addAdjustment(Item $item, Adjustment $adjustment): void
    {
        $item->adjustment()->save($adjustment);
        $this->recalculateAdjustment($item);
    }

}
