<?php

namespace App\Searchers\ElasticSearch;

use App\Contracts\SearcherEngine;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

final class ElasticSearcherEngine implements SearcherEngine
{
    public function __construct(public Client $elasticsearch)
    {}

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function search(string $query,Builder $builder): array
    {
        $params = $this->resolveSearchingParams($query,$builder->getModel());

        $result = $this->elasticsearch->search($params);

//        return $this->getResultingQueryBuilder($builder, $result);//Точно билдр возвращать - может ids?
        return $this->getIdsFromResult($result);
    }

    private function resolveSearchingParams(string $query,Model $model): array
    {
        return [
            'index' => 'models',
            'type' => $model->getTable(),
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'fields' => $model->getSearchable(),
                        'query' => $query,
                    ],
                ]
            ]
        ];
    }

    private function getIdsFromResult($result): array
    {
        return Arr::pluck($result['hits']['hits'],'_id');
    }

//    private function getResultingQueryBuilder($builder,$result): Builder
//    {
//        return $builder->whereIn('id',$this->getIdsFromResult($result));
//    }

    public function saveDocument(Model $model): void
    {
        $params = $this->resolveIndexingParam($model);

        $this->elasticsearch->index($params);
    }

    public function removeDocument(Model $model): void
    {
        $params = $this->resolveIndexingParam($model);

        $this->elasticsearch->delete($params);//??????
    }

    private function resolveIndexingParam(Model $model): array
    {
        return [
            'index' => 'models',
            'type' => $model->indexingAs(),
            'id' => $model->getKey(),
            'body' => $model->getSearchableBody()
        ];
    }
}
