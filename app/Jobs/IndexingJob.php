<?php

namespace App\Jobs;

use App\Facades\Elasticsearch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Queue\Queueable;

class IndexingJob implements ShouldQueue
{
    use Queueable;

    protected $model;
    /**
     * Create a new job instance.
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->model::indexModel();
    }
}
