<?php

namespace App\Filters;

use App\Contracts\Filter;
use App\Exceptions\InvalidFilterName;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * @throws InvalidFilterName
     */
//    public function scopeFilter(Builder $builder, array $allowedFields = []):Builder
//    {
//        if(empty($allowedFields))
//        {
//            return $builder;
//        }
//
//        $this->allowedFields = $allowedFields;
//
//        $queryFilter = app(Filter::class);
//
//        foreach ($this->getFilterFields() as $field){
//            $this->ensureFieldIsFilterable($field);
//
//            $queryFilter->filter($builder,$field,$this->getFilterValues($field));
//        }
//
//        return $builder;
//    }

    public function scopeFilter(Builder $builder, array $allowedFields = []):Builder
    {
        $queryFilter = app(QueryFilter::class);

        $queryFilter->apply($builder,$allowedFields);

        return $builder;
    }

}
