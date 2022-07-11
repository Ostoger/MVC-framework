<?php

namespace app\core;

use Psr\Log\AbstractLogger;
use RuntimeException;

class Logger extends AbstractLogger
{
    public string $logFile;

    public function __construct($logFile)
    {
        if (!file_exists($logFile)) {
            $directory = dirname($logFile);
            $status = mkdir($directory, 0777, 'recursive');
            if (!$status) {
                throw new RuntimeException();
            }
        }
        $this->logFile = $logFile;

    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        file_put_contents(
            $this->logFile,
            "{$level}, {$message}, at " . date('Y-m-d H:i:s') . PHP_EOL,
            FILE_APPEND);
    }


}