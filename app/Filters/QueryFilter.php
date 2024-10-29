<?php

namespace App\Filters;

use App\Contracts\Filter;
use App\Exceptions\InvalidFilterName;
use App\Facades\Logger;
use App\Http\Requests\QueryRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class QueryFilter
{
    public array $allowedFields = [];

    public function __construct(
        protected readonly QueryRequest $request)
    {}
    abstract function filter(Builder $builder,string $property ,array $values): void;

    /**
     * @throws InvalidFilterName
     */
    final public function apply(Builder $builder, array $allowedFields): void
    {
        if(empty($allowedFields))
            {
                return;
            }

        $this->allowedFields = $allowedFields;

        $this->request->getFilterQueryProperty()->each(function ($property) use ($builder)
        {
            $this->ensureFieldIsFilterable($property);

            $values = $this->request->getFilterValues($property);

            if ($this->isRelations($builder,$property)){
                $this->withRelationship($builder,$property,$values);

                return;
            }
//Можно вынести isRelationship() сюда - если true - писать в relationship[] и потом уже циклом обработать
            $this->filter($builder,$property,$values);
        });
    }

    /**
     * @throws InvalidFilterName
     */
    private function ensureFieldIsFilterable(string $field): void
    {
        if (! in_array($field,$this->allowedFields)){
            throw new InvalidFilterName('Invalid filter  name');
        }
    }

    final protected function isRelations(Builder $builder,string $property): bool
    {
        if(! Str::contains($property,'.')){
            return false;
        }

        $relationship = explode('.',$property)[0];

        return method_exists($builder->getModel(),$relationship);
    }

    final protected function withRelationship(Builder $builder,string $property,array $values): Builder
    {
        $parts = explode('.',$property);

        $relation = implode('.', Arr::except($parts,count($parts) - 1));
        $property = Arr::last($parts);

        return $builder->whereHas($relation,function (Builder $builder) use ($values,$property){
            $this->filter($builder,$property,$values);
        });
    }
}
