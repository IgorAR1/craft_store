<?php

namespace App\Console\Commands;

use App\Facades\Elasticsearch;
use App\Models\Product;
use Illuminate\Console\Command;

class IndexingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $this->info('Indexing all articles. This might take a while...');
        foreach (Product::all() as $product)
        {
            Elasticsearch::index([
                'index' => $product->getTable(),
                'type' => $product->getTable(),
                'id' => $product->getKey(),
                'body'  => $product->toArray()
            ]);
            $this->output->write('.');
        }
        $this->info('\nDone!');
    }
}
