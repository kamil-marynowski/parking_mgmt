<?php

namespace App\Services\CalculateParkingFeeStrategy;

use App\Models\ParkingArea;

class CalculateWeekendFee implements CalculateFeeInterface
{

    public function calculateFee(ParkingArea $parkingArea, float $hours): float
    {
        return ($parkingArea->getWeekendHourlyRate() * $hours) * ((100 - $parkingArea->getDiscountPercentage()) / 100);
    }
}