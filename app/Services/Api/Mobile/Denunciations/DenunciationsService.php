<?php

namespace App\Http\Services\Api\Mobile\Denunciations;

use App\Models\Denunciations;
use App\Models\DenunciationFiles;
use App\Models\HistoricalStatus;
use App\Models\Files;
use App\Models\Phones;
use App\Models\DenunciationsType;
use App\Models\Neighborhoods;
use App\Models\Status;
use App\Models\Address;
use App\Models\DenunciationAddress;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

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
    private $status;
    private $address;
    private $denunciationAddress;

    public function __construct(
                                    Denunciations $denunciations,
                                    HistoricalStatus $historicalStatus,
                                    DenunciationFiles $denunciationFiles,
                                    Files $files,
                                    Phones $phones,
                                    LogSystem $logSystem,
                                    DenunciationsType $denunciationsType,
                                    Neighborhoods $neighborhoods,
                                    Status $status,
                                    Address $address,
                                    DenunciationAddress $denunciationAddress
                               )
    {
        $this->denunciations       = $denunciations;
        $this->historicalStatus    = $historicalStatus;
        $this->denunciationFiles   = $denunciationFiles;
        $this->files               = $files;
        $this->phones              = $phones;
        $this->denunciationsType   = $denunciationsType;
        $this->logSystem           = $logSystem;
        $this->neighborhoods       = $neighborhoods;
        $this->status              = $status;
        $this->address             = $address;
        $this->denunciationAddress = $denunciationAddress;
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

            $valid_neighborhoods = $this->validNeighborhoods($request->neighborhood_id);

            if($valid_neighborhoods['http_code'] !== 200){

                DB::rollBack();

                return [
                    'http_code' => $valid_neighborhoods['http_code'],
                    'return'   => $valid_neighborhoods['return']
                ]; 
            }

            $phone = $this->phones->create([
                'number' => $request->phone
            ]);

            $denunciation = $this->denunciations->create([
                    "user_id"               => Auth()->id(),
                    "phone_id"              => $phone->id,
                    "denunciations_type_id" => $request->denunciations_type_id,
                    "description"           => $request->description,
                    "active"                => 1
            ]);

            $denunciation_update = $this->denunciations->where('id', $denunciation->id)
                                                       ->update([
                                                            'code' => $denunciation->id . '/' . $denunciation->created_at->format('Y')
                                                       ]);
            if(!$denunciation_update)
                return [
                    'http_code' => 400,
                    'return'   => ['message' => 'Code error on update']
                ];

            $get_status = $this->getStatusId($request->denunciations_type_id);

            if($get_status['http_code'] !== 200){

                DB::rollBack();

                return [
                    'http_code' => $get_status['http_code'],
                    'return'   => $get_status['return']
                ]; 
            }

            $historical = $this->historicalStatus->create([
                'user_id'         => Auth()->id(),
                'denunciation_id' => $denunciation->id,
                'status_id'       => $get_status['return']
            ]);
            
            if(!$historical)
                return [
                    'http_code' => 400,
                    'return'   => ['message' => 'historical error on create']
                ];

            $address = $this->address->create([
                'neighborhood_id' => $request->neighborhood_id,
                'content'         => json_decode($request->address_content) != null ? $request->address_content : null
            ]);
                
            if(!$address)
                return [
                    'http_code' => 400,
                    'return'   => ['message' => 'address error on create']
                ];

            $denunciation_address = $this->denunciationAddress->create([
                'denunciation_id' => $denunciation->id,
                'address_id'      => $address->id
            ]);
                
            if(!$denunciation_address)
                return [
                    'http_code' => 400,
                    'return'   => ['message' => 'denunciation address error on create']
                ];

            $files_savinding = $this->convertFiles($denunciation->id, $request->file('files'));
            
            if(!$files_savinding)
                return [
                    'http_code' => 400,
                    'return'   => ['message' => 'denunciation address error on create']
                ];

            DB::commit();

            return [
                'http_code' => 200,
                'return'   => ['message' => 'Denunciation created']
            ]; 

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

    private function getStatusId($type_id)
    {
        try {

            $status = $this->status->where('denunciations_type_id', $type_id)
                                   ->where('active', 1)
                                   ->orderBy('order','ASC')
                                   ->first();

            if($status != null){
                return [
                    'http_code' => 200,
                    'return'   => $status->id
                ];
            } else
                return [
                    'http_code' => 400,
                    'return'   => ['message' => 'Not found status']
                ];

        } catch (\Throwable $th) {

            $this->logSystem->log_system_error(500, 'Mobile/DenunciationsService/getStatusId()', $th);
            
            return [
                'http_code' => 500,
                'return'   => ['message' => 'getStatusId register error']
            ]; 
        }
    }

    private function convertFiles($denunciation_id, $files)
    {
        try {

            foreach($files as $file_item)
            {
                $file_name = $file_item->getClientOriginalName();
                $file_saved = $this->files->create([
                    'name'         => $file_name,
                    'file_content' => base64_encode(file_get_contents($file_item->getRealPath())),
                    'mime_type'    => $file_item->getMimeType()
                ]);

                if(!$file_saved)
                    return [
                        'http_code' => 400,
                        'return'   => ['message' => "file: $file_name error on create"]
                    ];

                $denunciation_files = $this->denunciationFiles->create([
                    'file_id'         => $file_saved->id,
                    'denunciation_id' => $denunciation_id
                ]);

                if(!$denunciation_files)
                    return [
                        'http_code' => 400,
                        'return'   => ['message' => "file: $file_name link denunciation error on create"]
                    ];
            }

            return [
                'http_code' => 200,
                'return'   => ['message' => "Created files"]
            ];

        } catch (\Throwable $th) {

            $this->logSystem->log_system_error(500, 'Mobile/DenunciationsService/convertFiles()', $th);
            
            return [
                'http_code' => 500,
                'return'   => ['message' => 'convertFiles register error']
            ]; 
        }
    }

}