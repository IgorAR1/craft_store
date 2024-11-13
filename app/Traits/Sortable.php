<?php

namespace App\Traits;

use App\Services\Sorters\Sorter;
use Illuminate\Database\Eloquent\Builder;

trait Sortable
{
    public function scopeSort(Builder $builder,array $allowedSortField):Builder
    {
        (app(Sorter::class))->sort($builder,$allowedSortField);

        return $builder;
    }
}
