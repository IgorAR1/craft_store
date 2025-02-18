<?php

namespace App\Services\Logger;

use Illuminate\Database\Eloquent\Model;
use Monolog\Handler\HandlerInterface;
use Monolog\LogRecord;

class MySqlHandler implements HandlerInterface
{

    public function handle(LogRecord $record): bool
    {
        $model = $this->getTable();
        $model->initiator_id = $record->context['initiator'];
        $model->entity_id = $record->context['subject'];
        $model->action = $record->context['action'];
        $model->save();
        return true;
    }

    private function getTable(): Model
    {
        return app(config('logging.channels.mysql.table'));
    }
    public function handleBatch(array $records): void
    {
        // TODO: Implement handleBatch() method.
    }
    public function isHandling(LogRecord $record): bool
    {
        return true;
    }

    public function close(): void
    {
        // TODO: Implement close() method.
    }
}
