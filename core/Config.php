<?php

declare(strict_types=1);

namespace Core;

class Config
{
    public static function get(string $file, string $key): mixed
    {
        $config = require __DIR__ . '/../config/' . $file . '.php';

        if (array_key_exists($key, $config)) {
            return $config[$key];
        }

        return '';
    }
}