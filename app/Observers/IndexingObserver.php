<?php

namespace App\Observers;

use App\Facades\Elasticsearch;
use App\Jobs\IndexingJob;
use Elastic\Elasticsearch\Client;

class IndexingObserver
{
    public function saved($model): void
    {
        $model->makeSearchable();

    }
    public function deleted($model): void
    {
        $model->makeUnsearchable();
    }
}
