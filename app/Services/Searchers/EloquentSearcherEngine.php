<?php

namespace App\Services\Searchers;

use App\Contracts\SearcherEngine;
use Illuminate\Database\Eloquent\Builder;

class EloquentSearcherEngine implements SearcherEngine
{
    public function search(string $query, Builder $builder): array
    {
//        TODO : вернуть массив id
        return [];
//        return  $builder->where('title', 'LIKE', '%' . $query . '%');
    }

    public function saveDocument($model): void
    {
        // TODO: Implement saveDocument() method.
    }

    public function removeDocument($model): void
    {
        // TODO: Implement removeDocument() method.
    }
}
