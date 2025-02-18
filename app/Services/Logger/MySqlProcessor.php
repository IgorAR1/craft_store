<?php

namespace App\Services\Logger;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

class MySqlProcessor implements ProcessorInterface
{
    public function __invoke(LogRecord $record): LogRecord
    {
        $record->extra = ['ff'];
        dd($record);
    }
}
