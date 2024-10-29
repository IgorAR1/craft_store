<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

final class QueryFilterExact extends QueryFilter
{
    public function filter(Builder $builder,string $property ,array|string $values): void
    {
        if (is_array($values)) {
            foreach ($values as $value) {
                $builder->where($property, 'LIKE', '%' . $value . '%');
            }

            return;
        }

        $builder->where($property, 'LIKE', '%' . $values . '%');
    }

//    protected function isRelations(Builder $builder,string $property): bool
//    {
//        if(! Str::contains($property,'.')){
//            return false;
//        }
//
//        $relationship = explode('.',$property)[0];
//
//        return method_exists($builder->getModel(),$relationship);
//    }
//
//    protected function withRelationship(Builder $builder,string $property,array $values): Builder
//    {
//        $parts = explode('.',$property);
//
//        $relation = implode('.',Arr::except($parts,count($parts) - 1));
//        $property = Arr::last($parts);
//
//        return $builder->whereHas($relation,function (Builder $builder) use ($values,$property){
//            $this->filter($builder,$property,$values);
//        });
//    }
}
