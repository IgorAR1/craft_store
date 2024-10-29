<?php

namespace App\Searchers;

use App\Contracts\Searcher;
use App\Observers\IndexingObserver;
use Illuminate\Database\Eloquent\Builder;
use function Symfony\Component\String\b;

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
        //Использовать type, индекс не нужно делать соответсвующим имени таблицы
        $params = [
            'index' => 'models',
            'type' => $this->indexingAs(),
            'id' => $this->getKey(),
            'body' => $this->getSearchableBody()
        ];

        $this->searchUsing()->saveDocument($params);
    }

    public function makeUnsearchable(): void
    {
        $params = [
            'index' => 'models',
            'id' => $this->getKey(),
        ];
        $this->searchUsing()->removeDocument($params);
    }

    public function indexModel()
    {
//        $builder->chunkById()
//        $documents = static::all();
//        $documents->
    }

//    private function getBuilders(Builder $builder, array $ids): Builder
//    {
//        return $builder->whereIn('id',$ids);
//    }
}
