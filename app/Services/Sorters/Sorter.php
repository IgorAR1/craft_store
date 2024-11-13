<?php

namespace App\Services\Sorters;

use App\Exceptions\InvalidFilter;
use App\Http\Requests\QueryRequest;
use Illuminate\Database\Eloquent\Builder;

abstract class Sorter
{
    protected array $allowedSortField = [];//Шляпа
    public function __construct(public readonly QueryRequest $request)
    {
    }
    abstract public function sort(Builder $builder,array $allowedSortField): void;

    protected function ensurePropertyIsSortable(string $field): void
    {
        if (! in_array($field,$this->allowedSortField)){
            throw new InvalidFilter('Invalid sorter name');
        }
    }
}



