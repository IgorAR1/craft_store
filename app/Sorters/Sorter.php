<?php

namespace App\Sorters;

use Illuminate\Database\Eloquent\Builder;

interface Sorter
{
    public function sort(Builder $builder): void;

    public function sortBy(Builder $builder, string $property, string $direction = 'desc'): void;
}
