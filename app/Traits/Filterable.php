<?php

namespace App\Traits;

use App\Contracts\Filter;
use App\Exceptions\InvalidFilterName;
use App\Services\Filters\QueryFilters;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public array $allowedFilters = [];
    /**
     * @throws InvalidFilterName
     */
    public function scopeFilter(Builder $builder, array $allowedFilters = []):Builder
    {
        $queryFilter = app(QueryFilters::class);

        foreach ($allowedFilters as $property => $filter){
            if (! $filter instanceof Filter) {
                $this->allowedFilters[$filter] = $queryFilter->factory->createExactFilter();
            }
            else $this->allowedFilters[$property] = $filter;
        }

        $queryFilter->apply($builder,$this->allowedFilters);

        return $builder;
    }

}
