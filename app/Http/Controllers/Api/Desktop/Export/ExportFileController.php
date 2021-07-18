<?php

namespace App\Http\Controllers\Api\Desktop\Export;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Services\Api\Desktop\Export\ExportFileService;

class ExportFileController extends Controller
{
    private $exportFileService;

    public function __construct(
                                    ExportFileService $exportFileService
                               )
    {
        $this->exportFileService = $exportFileService;
    }

    public function export(Request $request)
    {   
        if(isset($request->denunciation_id)){
            return response()->json($this->exportFileService->export($request->denunciation_id));
        } else
            return response()->json(['message' => 'Denunciation id required'], 400);
    }

}
