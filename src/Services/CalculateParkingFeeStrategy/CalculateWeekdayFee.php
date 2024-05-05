<?php

namespace App\Services\CalculateParkingFeeStrategy;

use App\Models\ParkingArea;

class CalculateWeekdayFee implements CalculateFeeInterface
{
    public function calculateFee(ParkingArea $parkingArea, float $hours): float
    {
        return ($parkingArea->getWeekdaysHourlyRate() * $hours) * ((100 - $parkingArea->getDiscountPercentage()) / 100);
    }
}