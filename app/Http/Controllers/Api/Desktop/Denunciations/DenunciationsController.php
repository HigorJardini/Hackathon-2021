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

    public function details(Request $request)
    {
        $details = $this->denunciationsService->details($request->denunciation_id);
        return response()->json($details['return'], $details['http_code']);
    }

    public function listStatus(Request $request)
    {
        $details_lsit_status = $this->denunciationsService->listStatus($request->denunciation_id);
        return response()->json($details_lsit_status['return'], $details_lsit_status['http_code']);
    }

    public function updateStatus(Request $request)
    {
        $details_lsit_status = $this->denunciationsService->updateStatus($request->denunciation_id, $request->status_id);
        return response()->json($details_lsit_status['return'], $details_lsit_status['http_code']);
    }

}
