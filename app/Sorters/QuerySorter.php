<?php

namespace App\Sorters;

use App\Exceptions\InvalidFilterName;
use App\Http\Requests\QueryRequest;
use Illuminate\Database\Eloquent\Builder;

class QuerySorter implements Sorter
{
    protected array $allowedSortField = [];//Шляпа
    public function __construct(public readonly QueryRequest $request)
    {}

    public function sort(Builder $builder): void
    {
        $direction = $this->request->getSortDirection();
        $this->request->getSortProperty()->each(fn ($property) =>
            $this->sortBy($builder,$property,$direction));
    }

    public function sortBy(Builder $builder, string $property, ?string $direction = 'desc'): void
    {
        $builder->orderBy($property,$direction);
    }

    private function ensureFieldIsFilterable(string $field): void
    {
        if (! in_array($field,$this->allowedFields)){
            throw new InvalidFilterName('Invalid sorter  name');
        }
    }
}
