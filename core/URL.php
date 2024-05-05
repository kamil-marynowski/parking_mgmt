<?php

declare(strict_types=1);

namespace Core;

class URL
{
    public static function to(string $route): string
    {
        return Config::get('app', 'base_uri') . '?route=' . $route;
    }
}