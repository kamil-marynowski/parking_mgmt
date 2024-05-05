<?php

return [
    'routes' => [
        '/admin/parking-areas' => [
            'controller' => \App\Controllers\ParkingAreaController::class,
            'action'     => 'index',
            'method'     => 'GET',
        ],
        '/admin/parking-areas/create' => [
            'controller' => \App\Controllers\ParkingAreaController::class,
            'action'     => 'create',
            'method'     => 'POST',
        ],
        '/admin/parking-areas/update' => [
            'controller' => \App\Controllers\ParkingAreaController::class,
            'action'     => 'update',
            'method'     => 'POST',
        ],
        '/get-parking-area' => [
            'controller' => \App\Controllers\ParkingAreaController::class,
            'action'     => 'getParkingArea',
            'method'     => 'GET',
        ],
        '/admin/parking-areas/delete' => [
            'controller' => \App\Controllers\ParkingAreaController::class,
            'action'     => 'delete',
            'method'     => 'POST',
        ],
        '/payments' => [
            'controller' => \App\Controllers\PaymentController::class,
            'action'     => 'index',
            'method'     => 'GET',
        ],
        '/payments/calculate-fee' => [
            'controller' => \App\Controllers\PaymentController::class,
            'action'     => 'calculateFee',
            'method'     => 'POST',
        ],
        '/' => [
            'controller' => \App\Controllers\DashboardController::class,
            'action'     => 'index',
            'method'     => 'GET',
        ],
    ],
];