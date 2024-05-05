<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return $this->view(view: 'dashboard.view.php');
    }
}