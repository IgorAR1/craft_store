<?php

namespace App\Console\Commands;

use App\Contracts\SearcherEngine;
use App\Jobs\IndexingJob;
use App\Searchers\Searchable;
use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class IndexingCommand extends Command
{
    public function __construct(public SearcherEngine $searcher)
    {
        parent::__construct();
    }

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

    public function handle(): void
    {
        $this->info('Indexing all articles. This might take a while...');

        foreach ($this->getModels() as  $model)
        {
            $this->output->write('.');

            if (in_array(Searchable::class,class_uses($model))) {
                IndexingJob::dispatch($model);
            }
        }

        $this->info("\n".'Done!');
    }

    private function getModels(): Collection
    {
        $models = collect(File::allFiles(app_path()))
            ->map(function ($item) {
                $path = $item->getRelativePathName();

                return sprintf('\%s%s',
                    Container::getInstance()->getNamespace(),
                    strtr(substr($path, 0, strrpos($path, '.')), '/', '\\'));

            })
            ->filter(function ($class) {
                $valid = false;

                if (class_exists($class)) {
                    $reflection = new \ReflectionClass($class);
                    $valid = $reflection->isSubclassOf(Model::class) &&
                        !$reflection->isAbstract();
                }

                return $valid;
            });

        return $models->values();
    }
}
