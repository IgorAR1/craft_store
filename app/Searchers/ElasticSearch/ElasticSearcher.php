<?php

namespace App\Searchers\ElasticSearch;

use App\Contracts\Searcher;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

final class ElasticSearcher implements Searcher
{
    public function __construct(public Client $elasticsearch)
    {}

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function search(string $query,Builder $builder): Builder
    {
        $params = $this->resolveSearchingParams($query,$builder->getModel());

        $result = $this->elasticsearch->search($params);

        return $this->getResultingQueryBuilder($builder, $result);
    }

    private function resolveSearchingParams(string $query,Model $model): array
    {
        return [
            'index' => $model->indexingAs(),
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'fields' => $model->searchable,
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

    private function getResultingQueryBuilder($builder,$result): Builder
    {
        return $builder->whereIn('id',$this->getIdsFromResult($result));
    }

    public function saveDocument($params): void
    {
        $this->elasticsearch->index($params);
    }

    public function removeDocument($params): void
    {
        $this->elasticsearch->index($params);
    }
}
