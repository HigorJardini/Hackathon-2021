<?php

namespace App\Http\Controllers\Api\Desktop\Denunciations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Services\Api\Desktop\Denunciations\DenunciationsService;

class DenunciationsController extends Controller
{
    private $denunciationsService;

    public function __construct(
                                DenunciationsService $denunciationsService
                               )
    {
        $this->denunciationsService = $denunciationsService;
    }

    public function list()
    {   
        $list = $this->denunciationsService->list();
        return response()->json($list['return'], $list['http_code']);
    }

}
