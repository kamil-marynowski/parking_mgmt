<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\ParkingArea;
use App\Repositories\ParkingAreaRepository;
use App\Validators\ParkingAreaValidator;
use Core\Controller;
use Core\Request;
use Core\Response;

final class ParkingAreaController extends Controller
{
    private ParkingAreaRepository $parkingAreaRepository;

    private ParkingAreaValidator $parkingAreaValidator;

    public function __construct()
    {
        $this->parkingAreaRepository = new ParkingAreaRepository();
        $this->parkingAreaValidator  = new ParkingAreaValidator();
    }

    /**
     * Returns parking areas management view.
     *
     * @return Response
     */
    public function index(): Response
    {
        /** @var ParkingArea[] $parkingAreas */
        $parkingAreas = $this->parkingAreaRepository->findAll();

        return $this->view(view: 'admin/parking_areas/index.view.php', data: [
            'parkingAreas' => $parkingAreas,
        ]);
    }

    /**
     * Creates new parking area.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $requestData = [
            'id'   => null,
            'name' => $request->post('name'),
            'weekdays_hourly_rate' => $request->post('weekdaysHourlyRate'),
            'weekend_hourly_rate' => $request->post('weekendHourlyRate'),
            'discount_percentage' => $request->post('discountPercentage'),
        ];

        $errors = $this->parkingAreaValidator->validate($requestData);
        if ($errors) {
            $responseData = [
                'status' => 'KO',
                'msg'    => 'Validation failed',
                'errors' => $errors,
            ];

            return $this->json($responseData, Response::UNPROCESSABLE_CONTENT);
        }

        $this->parkingAreaRepository->insert($requestData);

        $parkingArea = $this->parkingAreaRepository->getParkingAreaWithMaxId();

        $responseData = [
            'status' => 'OK',
            'msg' => 'Parking area created successfully',
            'id' => $parkingArea->getId(),
            'name' => $parkingArea->getName(),
            'weekdaysHourlyRate' => $parkingArea->getWeekdaysHourlyRate(),
            'weekendHourlyRate' => $parkingArea->getWeekendHourlyRate(),
            'discountPercentage' => $parkingArea->getDiscountPercentage(),
        ];

        return $this->json($responseData);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function update(Request $request): Response
    {
        $data = [
            'name'                 => $request->post('name'),
            'weekdays_hourly_rate' => $request->post('weekdaysHourlyRate'),
            'weekend_hourly_rate'  => $request->post('weekendHourlyRate'),
            'discount_percentage'  => $request->post('discountPercentage'),
        ];

        $errors = $this->parkingAreaValidator->validate($data);
        if ($errors) {
            $responseData = [
                'status' => 'KO',
                'msg'    => 'Validation failed',
                'errors' => $errors,
            ];

            return $this->json($responseData, Response::UNPROCESSABLE_CONTENT);
        }

        $id = (int)$request->post('id');
        $this->parkingAreaRepository->update(id: $id, data: $data);

        return $this->json([
            'status' => 'OK',
            'msg' => 'Parking area updated successfully',
        ]);
    }

    public function getParkingArea(Request $request): Response
    {
        $id = (int)$request->get('id');

        $parkingArea = $this->parkingAreaRepository->findById($id);

        $responseData = [
            'id' => $parkingArea->getId(),
            'name' => $parkingArea->getName(),
            'weekdaysHourlyRate' => $parkingArea->getWeekdaysHourlyRate(),
            'weekendHourlyRate' => $parkingArea->getWeekendHourlyRate(),
            'discountPercentage' => $parkingArea->getDiscountPercentage(),
        ];

        return $this->json($responseData);
    }

    public function delete(Request $request): Response
    {
        $parkingAreaId = (int)$request->post('id');

        $this->parkingAreaRepository->deleteById($parkingAreaId);

        return $this->json([
            'status' => 'OK',
            'msg' => 'Parking area deleted successfully',
        ]);
    }
}