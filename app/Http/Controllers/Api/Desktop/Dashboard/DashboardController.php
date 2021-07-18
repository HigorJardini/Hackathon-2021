<?php

namespace App\Http\Controllers\Api\Desktop\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Services\Api\Desktop\Dashboard\DashboardService;

class DashboardController extends Controller
{
    private $dashboardService;

    public function __construct(
                                  DashboardService $dashboardService
                               )
    {
        $this->dashboardService = $dashboardService;
    }

    public function home(Request $request)
    {   
        $home = $this->dashboardService->home($request->year);
        return response()->json($home['return'], $home['http_code']);
    }

}
