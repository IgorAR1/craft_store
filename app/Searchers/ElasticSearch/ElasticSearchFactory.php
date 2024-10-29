<?php

namespace App\Searchers\ElasticSearch;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

class ElasticSearchFactory
{

    public function __construct(private ClientBuilder $clientBuilder)
    {
        $this->clientBuilder = $clientBuilder::create();
    }

    /**
     * @throws AuthenticationException
     */
    public function make(array $config): Client
    {
        $this->clientBuilder->setHosts($config['hosts']);
        $this->clientBuilder->setSSLVerification($config['sslVerification']);

        if (isset($config['apiKey'])){
            $this->clientBuilder->setApiKey($config['apiKey']);
        }
        else{
            $this->clientBuilder->setBasicAuthentication($config['login'], $config['password']);
        }

        return $this->clientBuilder->build();
    }
}
