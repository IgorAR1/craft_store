<?php

namespace App\Services\Filters;

use App\Contracts\Filter;
use App\Exceptions\InvalidFilter;
use App\Factories\FilterFactory;
use App\Http\Requests\QueryRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class QueryFilters
{
    private array $filters = [];

    public function __construct(
        protected readonly QueryRequest $request,
        readonly FilterFactory $factory
    )
    {}
    /**
     * @throws InvalidFilter
     */

    public function apply(Builder $builder, array $allowedFilters): void
    {
        $requestedFilters = $this->request->getFilterQueryProperties();

        if(empty($allowedFilters) || $requestedFilters->isEmpty())
        {
            return;
        }

        $this->filters = $allowedFilters;

        $this->ensureFieldsIsFilterable($requestedFilters);

        $requestedFilters->each(function ($property) use ($builder)
        {
            $values = $this->resolveQueryValues($property);
//            $values = $this->request->getFilterValues($property);

            $filter = $this->filterUsing($property);

            if ($this->isRelations($builder,$property)){
                $this->withRelationship($filter,$builder,$property,$values);

                return;
            }

            $filter->filter($builder,$property,$values);
        });

    }


    private function filterUsing(string $name): Filter
    {
        return $this->filters[$name];
    }

    private function resolveQueryValues(string $property): array
    {
        return explode(',',$this->request->getFilterValues($property));
    }

    protected function isRelations(Builder $builder,string $property): bool
    {
        if(! Str::contains($property,'.')){
            return false;
        }

        $relationship = explode('.',$property)[0];

        return method_exists($builder->getModel(),$relationship);
    }

    protected function withRelationship(Filter $filter,Builder $builder,string $property,array $values): Builder
    {
        $parts = explode('.',$property);

        $relation = implode('.', Arr::except($parts,count($parts) - 1));
        $property = Arr::last($parts);

        return $builder->whereHas($relation,function (Builder $builder) use ($values,$property,$filter){
            $filter->filter($builder,$property,$values);
        });
    }

    /**
     * @throws InvalidFilter
     */
    private function ensureFieldsIsFilterable(Collection $requestedFilters): void
    {
        $allowedFilters = array_keys($this->filters);

        if ($requestedFilters->diff($allowedFilters)->isNotEmpty()) {
            throw new InvalidFilter('Invalid filter name');
        }
    }

    //Или так?Минус OCP получается
    private function filterExactly(Builder $builder,string $property ,array $values): \Closure
    {
        return function () use ($builder,$property,$values){
            foreach ($values as $value) {
                $builder->where($property, $value);
            }
        };
    }

    private function filterPartial(Builder $builder,string $property ,array $values): \Closure
    {
        return function () use ($builder,$property,$values){
            foreach ($values as $value) {
                $builder->where($property, 'LIKE', '%' . $value . '%');
            }
        };
    }
}
