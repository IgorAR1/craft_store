<?php

namespace App\Searchers;

use App\Contracts\Searcher;
use App\Observers\IndexingObserver;
use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public static function bootSearchable(){

        static::observe(new IndexingObserver());

    }
    public function scopeSearch(Builder $builder,string $query): Builder
    {
        $this->searchUsing()->search($query, $builder);

        return $builder;
    }

    public function indexingAs(): string
    {
        return $this->getTable();
    }

    public function getSearchableBody()
    {
        return collect($this)->only($this->searchableProperty);
    }

    public function searchUsing(): Searcher{

        return app(Searcher::class);
    }

    public function makeSearchable(): void
    {
        $this->searchUsing()->saveDocument($this);
    }

    public function makeUnsearchable(): void
    {
        $this->searchUsing()->removeDocument($this);
    }

    public function scopeIndexModel(Builder $builder): void
    {
        $builder->chunkById(100,function ($models){
            $models->each(fn($model) => $model->makeSearchable());
        });
    }

    public function scopeUnindexModel(Builder $builder): void
    {
        $builder->chunkById(100,function ($models){
            $models->each(fn($model) => $model->makeUnSearchable());
        });
    }

    public function getSearchable():array
    {
        return $this->searchableProperty;
    }
}
