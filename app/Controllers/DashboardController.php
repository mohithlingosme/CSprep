<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\DashboardService;

final class DashboardController extends Controller
{
    public function index(): void
    {
        $dashboard = (new DashboardService())->metrics();

        $this->render('dashboard/index', [
            'title' => 'Founder Dashboard',
            'dashboard' => $dashboard,
        ]);
    }
}
