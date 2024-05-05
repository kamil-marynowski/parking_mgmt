<?php

declare(strict_types=1);

namespace App\Services\CalculateParkingFeeStrategy;

use App\Models\ParkingArea;

interface CalculateFeeInterface
{
    public function calculateFee(ParkingArea $parkingArea, float $hours): float;
}