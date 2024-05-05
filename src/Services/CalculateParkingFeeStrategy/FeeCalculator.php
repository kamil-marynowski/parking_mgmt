<?php

declare(strict_types=1);

namespace App\Services\CalculateParkingFeeStrategy;

use App\Models\ParkingArea;

class FeeCalculator
{
    private $strategy;

    public function __construct($isWeekend)
    {
        if ($isWeekend) {
            $this->strategy = new CalculateWeekendFee();
        } else {
            $this->strategy = new CalculateWeekdayFee();
        }
    }

    public function calculateFee(ParkingArea $parkingArea, float $hours): float
    {
        return $this->strategy->calculateFee($parkingArea, $hours);
    }
}