<?php

namespace App\Factories;

use App\Contracts\Filter;
use App\Enums\SqlOperators;
use App\Services\Filters\QueryFilterExact;
use App\Services\Filters\QueryFilterPartial;
use App\Services\Filters\QueryFilterRange;

class FilterFactory
{
    public function createRangeFilter(SqlOperators $operator): Filter
    {
        return new QueryFilterRange($operator);
    }

    public function createExactFilter(): Filter
    {
        return new QueryFilterExact();
    }
    public function createPartialFilter(): Filter
    {
        return new QueryFilterPartial();
    }
}
