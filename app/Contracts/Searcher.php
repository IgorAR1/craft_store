<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface Searcher//Возвращать array или builder?
{
//    public function search(string $query,Builder $builder): Builder; //array?;
    public function search(string $query,Builder $builder): array; //array?;

    public function saveDocument(Model $model): void;

    public function removeDocument(Model $model): void;
}
