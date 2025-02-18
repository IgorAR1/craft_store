<?php

namespace App\Observers;

use App\Enums\ActionType;
use App\Facades\UserActivityLogger as Log;
use Illuminate\Database\Eloquent\Model;

class ProductObserver
{
    public function created(Model $product): void
    {
        Log::initiateBy(auth()->user())
            ->performedOn($product)
            ->log(ActionType::CREATED);
    }

    public function saved(Model $product): void
    {
        if ($product->wasChanged()){
            Log::initiateBy(auth()->user())
                ->performedOn($product)
                ->log(ActionType::EDITED);
        }
    }

    public function deleted(Model $product): void
    {
            Log::initiateBy(auth()->user())
                ->performedOn($product)
                ->log(ActionType::DELETED);
    }
}
