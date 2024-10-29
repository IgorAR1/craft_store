<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Filter
{
    public function filter(Builder $builder,string $property ,array $values): void;
}
