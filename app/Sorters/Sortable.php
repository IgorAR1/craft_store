<?php

namespace App\Sorters;

use Illuminate\Database\Eloquent\Builder;

trait Sortable
{
    public function scopeSort(Builder $builder,string $direction):Builder
    {
        (app(Sorter::class))->sort($builder);

        return $builder;
    }
}
