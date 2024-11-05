<?php

namespace App\Filters;

use App\Contracts\Filter;
use App\Exceptions\InvalidFilterName;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public array $filters = [];
    /**
     * @throws InvalidFilterName
     */
    public function scopeFilter(Builder $builder, array $allowedFields = []):Builder
    {
        $queryFilter = app(QueryFilter::class);

        $queryFilter->apply($builder,$allowedFields);

        return $builder;
    }

}
