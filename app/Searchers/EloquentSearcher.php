<?php

namespace App\Searchers;

use App\Contracts\Searcher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class EloquentSearcher implements Searcher
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
