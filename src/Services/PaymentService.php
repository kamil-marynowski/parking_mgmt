<?php

declare(strict_types=1);

namespace App\Services;

use App\Helpers\DateHelper;
use App\Repositories\ParkingAreaRepository;
use App\Services\CalculateParkingFeeStrategy\FeeCalculator;
use Core\Request;
use DateTimeImmutable;

class PaymentService
{
    private ParkingAreaRepository $parkingAreaRepository;

    private CurrencyService $currencyService;

    public function __construct()
    {
        $this->parkingAreaRepository = new ParkingAreaRepository();
        $this->currencyService       = new CurrencyService();
    }

    public function calculateFee(Request $request): float
    {
        $parkingAreaId = (int)$request->post('parking_area_id');
        $startTime     = $request->post('start_time');
        $endTime       = $request->post('end_time');
        $date          = $request->post('date');
        $currency      = $request->post('currency');

        $startDateTime = new DateTimeImmutable($date . ' ' . $startTime);
        $endDateTime   = new DateTimeImmutable($date . ' ' . $endTime);

        $isWeekend = DateHelper::isWeekend($startDateTime);

        $hours = $this->calculateHoursDiff($startDateTime, $endDateTime);

        $parkingArea = $this->parkingAreaRepository->findById($parkingAreaId);


        $feeCalculator = new FeeCalculator($isWeekend);
        $parkingFee = $feeCalculator->calculateFee($parkingArea, $hours);

        if ($currency !== 'USD') {
            $parkingFee = $this->currencyService->convertUsdTo(currency: $currency, value: $parkingFee);
        }

        return $parkingFee;
    }

    /**
     * Returns time difference in hours
     *
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     * @return float
     */
    private function calculateHoursDiff(DateTimeImmutable $start, DateTimeImmutable $end): float
    {
        $timeDiff = $start->diff($end);

        return (float)($timeDiff->h + ($timeDiff->i / 60));
    }
}