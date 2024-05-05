<?php

declare(strict_types=1);

namespace App\Models;

class ParkingArea
{
    private int $id;

    private string $name;

    private float $weekdaysHourlyRate;

    private float $weekendHourlyRate;

    private int $discountPercentage;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getWeekdaysHourlyRate(): float
    {
        return $this->weekdaysHourlyRate;
    }

    public function setWeekdaysHourlyRate(float $weekdaysHourlyRate): void
    {
        $this->weekdaysHourlyRate = $weekdaysHourlyRate;
    }

    public function getWeekendHourlyRate(): float
    {
        return $this->weekendHourlyRate;
    }

    public function setWeekendHourlyRate(float $weekendHourlyRate): void
    {
        $this->weekendHourlyRate = $weekendHourlyRate;
    }

    public function getDiscountPercentage(): int
    {
        return $this->discountPercentage;
    }

    public function setDiscountPercentage(int $discountPercentage): void
    {
        $this->discountPercentage = $discountPercentage;
    }
}