<?php

namespace App\Services\Filters;

use App\Contracts\Filter;
use Illuminate\Database\Eloquent\Builder;


class FieldFilter
{
    private Filter $filter;
    private string $name;
    public function __construct(Filter $filter,string $name)
    {
        $this->filter = $filter;
        $this->name = $name;
    }

    public function execute(Builder $builder,string $values): void
    {
        $values = $this->resolveQueryValues($values);

        $this->filter->filter($builder,$this->name,$values);
    }

    private function resolveQueryValues(string $values): array
    {
        return explode(',',$values);
    }

}
