<?php

declare(strict_types=1);

namespace app\core;

class ConfigParser
{
    private string $configFile;

    public function __construct($configFile)
    {
        $this->configFile = $configFile;
    }

    public function load(): void
    {
        $configFile = file($this->configFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($configFile as $line) {
            if ($line[0] !== '#') {
                [$key, $value] = explode('=', $line, 2);
                $_SERVER[$key] = $value;
                $_ENV[$key] = $value;
                putenv("{$key}={$value}");
            }
        }
    }
}