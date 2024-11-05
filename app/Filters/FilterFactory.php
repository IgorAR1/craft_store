<?php

namespace App\Filters;

use App\Contracts\Filter;
use App\Enums\SqlOperators;
use App\Exceptions\FilterUndefined;

class FilterFactory
{
//    public function createFilter(string $filterName): Filter
//    {
//        switch ($filterName) {
//            case 'range>':
//                return new QueryFilterRange(SqlOperators::GREATER_THAN);
//            case 'range<':
//                return new QueryFilterRange(SqlOperators::LESS_THAN);
//            case 'exact' :
//                return new QueryFilterExact();
//            default :
//                throw new FilterUndefined('Filter'.' '.$filterName.' '.'is undefined');
//        }
//    }
    public function createRangeFilter(SqlOperators $operator): Filter
    {
        return new QueryFilterRange($operator);
    }

    public function createExactFilter(): Filter
    {
        return new QueryFilterExact();
    }

}
