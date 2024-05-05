<?php

declare(strict_types=1);

namespace App\Helpers;

use DateTimeImmutable;

class DateHelper
{
    /**
     * Checks if datetime is weekend.
     *
     * @param DateTimeImmutable $datetime
     * @return bool
     */
    public static function isWeekend(DateTimeImmutable $datetime): bool
    {
        return $datetime->format('N') === '6' || $datetime->format('N') === '7';
    }
}