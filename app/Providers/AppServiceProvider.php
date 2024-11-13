<?php

namespace App\Providers;

use App\Contracts\SearcherEngine;
use App\Services\Sorters\Sorter;
use App\Facades\FilterFactory;
use App\Services\Searchers\ElasticSearch\ElasticSearchConnection;
use App\Services\Searchers\ElasticSearch\ElasticSearcherEngine;
use App\Services\Sorters\QuerySorter;
use Elastic\Elasticsearch\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
//        $this->app->bind(QueryFilter::class,QueryFilterPartial::class);

//        $this->app->bind('log',ActivityLogger::class);
//        $this->app->bind(Searcher::class,ElasticSearcher::class);
        $this->app->singleton(SearcherEngine::class,ElasticSearcherEngine::class);
        $this->app->bind('filterFactory', FilterFactory::class);
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
