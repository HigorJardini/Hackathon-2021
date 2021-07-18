<?php

namespace App\Http\Controllers\Api\Mobile\Denunciations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Services\Api\Mobile\Denunciations\DenunciationsService;

class DenunciationsController extends Controller
{
    private $denunciationsService;

    public function __construct(
                                DenunciationsService $denunciationsService
                               )
    {
        $this->denunciationsService = $denunciationsService;
    }

    public function register(Request $request)
    {   
        $list = $this->denunciationsService->register($request);
        return response()->json($list['return'], $list['http_code']);
    }
}
