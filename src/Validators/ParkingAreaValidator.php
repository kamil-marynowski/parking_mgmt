<?php

declare(strict_types=1);

namespace App\Validators;

class ParkingAreaValidator extends Validator implements ValidatorInterface
{
    protected array $rules = [
        'name' => ['required', 'string', ['name' => 'maxLength', 'value' => 255]],
        'weekdays_hourly_rate' => ['required'],
        'weekend_hourly_rate' => ['required'],
        'discount_percentage' => ['required'],
    ];

    protected array $messages = [
        'name' => ['required' => 'Name is required', 'string' => 'Name must be a string', 'maxLength' => 'Name must be max 255 characters'],
        'weekdays_hourly_rate' => ['required' => 'Weekdays hourly rate is required'],
        'weekend_hourly_rate' => ['required' => 'Weekend hourly rate is required'],
        'discount_percentage' => ['required' => 'Discount percentage is required'],
    ];
}