<?php

namespace App\Services\Searchers\ElasticSearch;

use App\Factories\ElasticSearchFactory;
use Elastic\Elasticsearch\Exception\AuthenticationException;

class ElasticSearchConnection
{
    public function __construct(private ElasticSearchFactory $factory)
    {
    }

    /**
     * @throws AuthenticationException
     */
    public function createConnection()
    {
        $config = $this->getConfig();
        return $this->factory->make($config);
    }

    private function getConfig(): array
    {
//        dd(config('elasticsearch'));
        return config('elasticsearch');
    }
}
