<?php

namespace App\Http\Services\Api\Mobile\Denunciations;

use App\Models\Denunciations;
use App\Models\DenunciationFiles;
use App\Models\HistoricalStatus;
use App\Models\Files;
use App\Models\Phones;
use App\Models\DenunciationsType;
use App\Models\Neighborhoods;

use Illuminate\Support\Facades\DB;

use App\Services\Api\LogSystem;

class DenunciationsService
{
    private $denunciations;
    private $historicalStatus;
    private $denunciationFiles;
    private $files;
    private $phones;
    private $logSystem;
    private $denunciationsType;
    private $neighborhoods;

    public function __construct(
                                    Denunciations $denunciations,
                                    HistoricalStatus $historicalStatus,
                                    DenunciationFiles $denunciationFiles,
                                    Files $files,
                                    Phones $phones,
                                    LogSystem $logSystem,
                                    DenunciationsType $denunciationsType,
                                    Neighborhoods $neighborhoods
                               )
    {
        $this->denunciations     = $denunciations;
        $this->historicalStatus  = $historicalStatus;
        $this->denunciationFiles = $denunciationFiles;
        $this->files             = $files;
        $this->phones            = $phones;
        $this->denunciationsType = $denunciationsType;
        $this->logSystem         = $logSystem;
        $this->neighborhoods     = $neighborhoods;
    }

    public function register($request)
    {
        DB::beginTransaction();

        try {

            $valid_type = $this->validDenuncitionType($request->denunciations_type_id);

            if($valid_type['http_code'] !== 200){

                DB::rollBack();

                return [
                    'http_code' => $valid_type['http_code'],
                    'return'   => $valid_type['return']
                ]; 
            }

            $valid_type = $this->validDenuncitionType($request->neighborhood_id);

            if($valid_type['http_code'] !== 200){

                DB::rollBack();

                return [
                    'http_code' => $valid_type['http_code'],
                    'return'   => $valid_type['return']
                ]; 
            }


            $phone = $this->phones->create([
                'number' => $request->phone
            ]);

            $denunciation = $this->denunciations->create([
                    "user_id"               => Auth()->id(),
                    "phone_id"              => $phone->id,
                    "denunciations_type_id" => $request->denunciations_type_id
            ]);

            dd($denunciation);

            DB::commit();

        } catch (\Throwable $th) {

            DB::rollBack();

            $this->logSystem->log_system_error(500, 'Mobile/DenunciationsService/register()', $th);
            
            return [
                'http_code' => 500,
                'return'   => ['message' => 'Denunciation Mobile register error']
            ]; 
        }
    }

    private function validDenuncitionType($type_id)
    {
        try {

            $type = $this->denunciationsType->where('id', $type_id)
                                            ->where('active', 1)
                                            ->first();

            if($type != null){
                return [
                    'http_code' => 200,
                    'return'   => true
                ];
            } else
                return [
                    'http_code' => 400,
                    'return'   => ['message' => 'Not found denunciation type']
                ];

        } catch (\Throwable $th) {

            $this->logSystem->log_system_error(500, 'Mobile/DenunciationsService/validDenuncitionType()', $th);
            
            return [
                'http_code' => 500,
                'return'   => ['message' => 'validDenuncitionType register error']
            ]; 
        }
    }

    private function validNeighborhoods($neighborhood_id)
    {
        try {

            $neighborhood = $this->neighborhoods->where('id', $neighborhood_id)
                                        ->first();

            if($neighborhood != null){
                return [
                    'http_code' => 200,
                    'return'   => true
                ];
            } else
                return [
                    'http_code' => 400,
                    'return'   => ['message' => 'Not found neighborhood']
                ];

        } catch (\Throwable $th) {

            $this->logSystem->log_system_error(500, 'Mobile/DenunciationsService/validNeighborhoods()', $th);
            
            return [
                'http_code' => 500,
                'return'   => ['message' => 'Neighborhood register error']
            ]; 
        }
    }

}