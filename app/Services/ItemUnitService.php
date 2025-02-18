<?php

namespace App\Services;

use App\Models\Adjustment;
use App\Models\ItemUnit;

class ItemUnitService
{
    public function recalculateTotal(ItemUnit $unit): void
    {
//        $this->recalculateAdjustmentTotal($unit);???
        $unit->total_price = $unit->getProductPrice() - $unit->adjustments_total;

        $unit->save();
    }

    public function recalculateAdjustmentTotal(ItemUnit $unit): void
    {
        $unit->adjustment_total = $unit->adjustment()->sum('amount');
    }

    public function addAdjustment(Adjustment $adjustment,ItemUnit $unit): void
    {
        $unit->adjustment()->save($adjustment);

        $this->recalculateAdjustmentTotal($unit);
    }
}
