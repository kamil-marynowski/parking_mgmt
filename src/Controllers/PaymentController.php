<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\DateHelper;
use App\Repositories\ParkingAreaRepository;
use App\Services\PaymentService;
use Core\Controller;
use Core\Request;
use Core\Response;
use GuzzleHttp\Client;

final class PaymentController extends Controller
{
    private ParkingAreaRepository $parkingAreaRepository;

    private PaymentService $paymentService;

    public function __construct()
    {
        $this->parkingAreaRepository = new ParkingAreaRepository();
        $this->paymentService        = new PaymentService();
    }

    /**
     * Returns payments view.
     *
     * @return Response
     */
    public function index(): Response
    {
        $parkingAreas = $this->parkingAreaRepository->findAll();

        $now = new \DateTimeImmutable();

        return $this->view(view: 'payments/index.view.php', data: [
            'parkingAreas' => $parkingAreas,
            'now'          => $now,
        ]);
    }

    public function calculateFee(Request $request): Response
    {
        $parkingFee = $this->paymentService->calculateFee($request);

        return $this->json([
            'parkingFee' => number_format($parkingFee, 2, '.', '')
        ]);
    }
}