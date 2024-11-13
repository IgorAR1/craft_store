<?php

namespace App\Services\Sorters;


use App\Exceptions\InvalidFilter;
use Illuminate\Database\Eloquent\Builder;

class QuerySorter extends Sorter
{
    /**
     * @throws InvalidFilter
     */
    public function sort(Builder $builder,array $allowedSortField): void
    {
        $this->allowedSortField = $allowedSortField;
        $direction = $this->request->getSortDirection();

        $this->request->getSortProperties()->each(function ($property) use ($builder, $direction)
            {
                $this->ensurePropertyIsSortable($property);
                $this->sortBy($builder, $property, $direction);
            });
    }

    public function sortBy(Builder $builder, string $property, ?string $direction = 'desc'): void
    {
        $builder->orderBy($property,$direction);
    }

}
