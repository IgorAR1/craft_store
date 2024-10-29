<?php

namespace App\Searchers;

use App\Contracts\Searcher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class EloquentSearcher implements Searcher
{
    public function search(string $query, Builder $builder): Builder
    {
        return  $builder;
    }

    public function saveDocument($params): void
    {
        // TODO: Implement saveDocument() method.
    }

    public function removeDocument($params): void
    {
        // TODO: Implement removeDocument() method.
    }
}
