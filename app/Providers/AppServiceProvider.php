<?php

namespace App\Providers;

use App\Contracts\SearcherEngine;
use App\Filters\QueryFilter;
use App\Filters\QueryFilterExact;
use App\Searchers\ElasticSearch\ElasticSearchConnection;
use App\Searchers\ElasticSearch\ElasticSearcherEngine;
use App\Searchers\EloquentSearcherEngine;
use App\Sorters\QuerySorter;
use App\Sorters\Sorter;
use Elastic\Elasticsearch\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(QueryFilter::class,QueryFilterExact::class);

//        $this->app->bind('log',ActivityLogger::class);
//        $this->app->bind(Searcher::class,ElasticSearcher::class);
        $this->app->singleton(SearcherEngine::class,ElasticSearcherEngine::class);

        $this->app->bind('elasticsearch',Client::class);
        $this->app->bind(Sorter::class,QuerySorter::class);
        $this->app->bind(Client::class,fn() =>
            app(ElasticSearchConnection::class)->createConnection());
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        Gate::before(fn() => dd());
    }
}
