<?php

namespace App\Filters;

use App\Contracts\Filter;
use App\Exceptions\FilterUndefined;
use App\Exceptions\InvalidFilterName;
use App\Http\Requests\QueryRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class QueryFilter
{
    public array $allowedFields = [];

    public function __construct(
        protected readonly QueryRequest $request,
        readonly FilterFactory $factory
    )
    {}
    /**
     * @throws InvalidFilterName
     */
//    final public function apply(Builder $builder, array $allowedFields): void
//    {
//        if(empty($allowedFields))
//            {
//                return;
//            }
//
//        $this->allowedFields = $allowedFields;
//
//        $this->request->getFilterQueryProperties()->each(function ($property) use ($builder)
//        {
//            $this->ensureFieldIsFilterable($property);
//
//            $values = $this->request->getFilterValues($property);
//
//            if ($this->isRelations($builder,$property)){
//                $this->withRelationship($builder,$property,$values);
//
//                return;
//            }
//            $this->filter($builder,$property,$values);
//        });
//    }

    final public function apply(Builder $builder, array $allowedFields): void
    {
        if(empty($allowedFields))
        {
            return;
        }

        foreach ($allowedFields as $property => $filter){
          if (! $filter instanceof Filter) {
              $this->allowedFields[$filter] = $this->factory->createExactFilter();
          }
          else $this->allowedFields[$property] = $filter;
        }

//        $this->allowedFields = $allowedFields;

//        $this->ensureFieldsIsFilterable();
//        foreach ($allowedFields as $field){
//            if (is_array($field)) {
//                $property = $field[1];
//
////                $this->ensureFieldIsFilterable($property);
//
//                $filter = $this->factory->createRangeFilter(SqlOperators::GREATER_THAN);
//                $values = $this->request->getFilterValues($field[1]);
//
//                dd([$filter,$values]);
//            }

        $this->request->getFilterQueryProperties()->each(function ($property) use ($builder)
        {
            $this->ensureFieldIsFilterable($property);

            $values = $this->resolveQueryValues($property);

            $filter = $this->filterUsing($property);

            if ($this->isRelations($builder,$property)){
                $this->withRelationship($filter,$builder,$property,$values);

                return;
            }

            $filter->filter($builder,$property,$values);
        });

//            if ($this->isRelations($builder,$field)){
//                $this->withRelationship($builder,$field,$values);
//
//                return;
//            }
//            $filter->filter($builder,$field,$values);
//        }
//        $this->allowedFields = $allowedFields;
//
//        $this->request->getFilterQueryProperties()->each(function ($property) use ($builder)
//        {
//            $this->ensureFieldIsFilterable($property);
//
//            $values = $this->request->getFilterValues($property);
//
//            if ($this->isRelations($builder,$property)){
//                $this->withRelationship($builder,$property,$values);
//
//                return;
//            }
//            $this->filter($builder,$property,$values);
//        });
    }

    private function filterUsing(string $name): Filter
    {
        return $this->allowedFields[$name];
//        return $this->factory->createFilter($this->allowedFields[$name]);
    }

    private function resolveQueryValues(string $property): array
    {
        return explode(',',$this->request->getFilterValues($property));
    }

    /**
     * @throws InvalidFilterName
     */
    private function ensureFieldIsFilterable(string $field): void
    {
        $allowedFields = array_keys($this->allowedFields);

        if (! in_array($field,$allowedFields)){
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

    final protected function withRelationship(Filter $filter,Builder $builder,string $property,array $values): Builder
    {
        $parts = explode('.',$property);

        $relation = implode('.', Arr::except($parts,count($parts) - 1));
        $property = Arr::last($parts);

        return $builder->whereHas($relation,function (Builder $builder) use ($values,$property,$filter){
            $filter->filter($builder,$property,$values);
        });
    }
}
