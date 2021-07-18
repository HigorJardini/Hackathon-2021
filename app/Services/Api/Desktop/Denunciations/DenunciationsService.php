<?php

namespace App\Http\Services\Api\Desktop\Denunciations;

use App\Models\Denunciations;
use App\Models\DenunciationFiles;
use App\Models\HistoricalStatus;

use App\Services\Api\LogSystem;

class DenunciationsService
{
    private $denunciations;
    private $historicalStatus;
    private $denunciationFiles;
    private $logSystem;

    public function __construct(
                                    Denunciations $denunciations,
                                    HistoricalStatus $historicalStatus,
                                    DenunciationFiles $denunciationFiles,
                                    LogSystem $logSystem
                               )
    {
        $this->denunciations     = $denunciations;
        $this->historicalStatus  = $historicalStatus;
        $this->denunciationFiles = $denunciationFiles;
        $this->logSystem         = $logSystem;
    }

    public function list()
    {
        try {
            $denunciations = $this->denunciations->select('denunciations.id', 'denunciations.code', 'denunciations_type.name as type')
                                                ->selectRaw('DATE_FORMAT(denunciations.created_at, "%d/%m/%Y") as day')
                                                ->selectRaw('DATE_FORMAT(denunciations.created_at, "%H:%i") as hour')
                                                ->leftJoin('denunciations_type', 'denunciations_type.id', '=', 'denunciations.denunciations_type_id')
                                                ->where('active', 1)
                                                ->get()
                                                ->toArray();
            foreach($denunciations as $key => $denunciation){

                $get_status = $this->getStatus($denunciation['id']);

                if($get_status['http_code'] == 200)
                    $denunciations[$key]['status'] = $get_status['return'];
                else
                    return $get_status;
            }
            
            return [
                'http_code' => 200,
                'return'   => $denunciations
            ];

        } catch (\Throwable $th) {

            $this->logSystem->log_system_error(500, 'DenunciationsService/list()', $th);
            
            return [
                'http_code' => 500,
                'return'   => ['message' => 'List denunciations error']
            ];
        }
    }

    private function getStatus($denunciation_id)
    {
        try {
            $status = $this->historicalStatus->select('status.name')
                                ->where('historical_status.denunciation_id', $denunciation_id)
                                ->leftJoin('status', 'status.id', '=', 'historical_status.status_id')
                                ->orderBy('historical_status.id', 'DESC')
                                ->first();
            
            return [
                'http_code' => 200,
                'return'    => $status->name
            ];

        } catch (\Throwable $th) {

            $this->logSystem->log_system_error(500, 'DenunciationsService/getStatus()', $th);

            return [
                'http_code' => 500,
                'return'   => ['message' => 'List denunciations getStatus() error']
            ];
        }

    }

    public function details($denunciation_id)
    {
        try {
            
            $details = $this->denunciations->select(
                                            'denunciations.id',
                                            'denunciations.code',
                                            'denunciations_type.name as type',
                                            'denunciations.description'
                                          )
                                          ->selectRaw('DATE_FORMAT(denunciations.created_at, "%d/%m/%Y") as day')
                                          ->selectRaw('DATE_FORMAT(denunciations.created_at, "%H:%i") as hour')
                                          ->selectRaw('DATE_FORMAT(denunciations.created_at, "%d/%m/%Y %H:%i:%s") as created')
                                          ->leftJoin('denunciations_type', 'denunciations_type.id', '=', 'denunciations.denunciations_type_id')
                                          ->where('denunciations.id', $denunciation_id)
                                          ->first()
                                          ->toArray();
            
            $getAddress = $this->getDenunciationAdress($denunciation_id);

            if($getAddress['http_code'] == 200)
                $details['denunciation_address'] =  $getAddress['return'];
            else
                return [
                    'http_code' => $getAddress['http_code'],
                    'return'    => $getAddress['return']
                ];

            $getUser = $this->getDenunciationUser($denunciation_id);
            
            if($getUser['http_code'] == 200)
                $details['denunciation_user'] =  $getUser['return'];
            else
                return [
                    'http_code' => $getUser['http_code'],
                    'return'    => $getUser['return']
                ];

            $getHistoricalStatus = $this->getDenunciationHistoricalStatus($denunciation_id);
            
            if($getHistoricalStatus['http_code'] == 200)
                $details['denunciation_historical_status'] =  $getHistoricalStatus['return'];
            else
                return [
                    'http_code' => $getHistoricalStatus['http_code'],
                    'return'    => $getHistoricalStatus['return']
                ];

            $getHistoricalStatus = $this->getDenunciationContact($denunciation_id);
            
            if($getHistoricalStatus['http_code'] == 200)
                $details['denunciation_contact'] =  $getHistoricalStatus['return'];
            else
                return [
                    'http_code' => $getHistoricalStatus['http_code'],
                    'return'    => $getHistoricalStatus['return']
                ];

            $getDownloadCheck = $this->getDenunciationDownloadCheck($denunciation_id);
        
            if($getDownloadCheck['http_code'] == 200)
                $details['files_download'] =  $getDownloadCheck['return'];
            else
                return [
                    'http_code' => $getDownloadCheck['http_code'],
                    'return'    => $getDownloadCheck['return']
                ];

            return [
                'http_code' => 200,
                'return'    => $details
            ];

        } catch (\Throwable $th) {
            $this->logSystem->log_system_error(500, 'DenunciationsService/details()', $th);

            return [
                'http_code' => 500,
                'return'   => ['message' => 'List denunciations details() error']
            ];
        }
    }

    private function getDenunciationAdress($denunciation_id)
    {
        try {
            $address = $this->denunciations->select(
                                                'address.content as address_content',
                                                'neighborhoods.name as neighborhood',
                                                'citys.name as city',
                                                'states.name as state_name',
                                                'states.uf as state_uf'
                                            )
                                        ->leftJoin('denunciation_address', 'denunciation_address.denunciation_id', '=', 'denunciations.id')
                                        ->leftJoin('address', 'address.id', '=', 'denunciation_address.address_id')
                                        ->leftJoin('neighborhoods', 'neighborhoods.id', '=', 'address.neighborhood_id')
                                        ->leftJoin('citys', 'citys.id', '=', 'neighborhoods.city_id')
                                        ->leftJoin('states', 'states.id', '=', 'citys.state_id')
                                        ->where('denunciations.id', $denunciation_id)
                                        ->first()
                                        ->toArray();
            
            if($address !== null){

                if($address['address_content'] != null){
                    $address_content = json_decode($address['address_content']);

                    if($address_content != null){
                        foreach($address_content as $key => $content){
                            $address[$key] = $content;
                            unset($address['address_content']);
                        }
                    } else {
                        unset($address['address_content']);
                    }
                } else {
                    unset($address['address_content']);
                }
                
                return [
                    'http_code' => 200,
                    'return'   => $address
                ]; 

            } else {
                return [
                    'http_code' => 400,
                    'return'   => ['message' => 'Address from denunciations getDenunciationAdress() error']
                ];  
            }
            

        } catch (\Throwable $th) {
            $this->logSystem->log_system_error(500, 'DenunciationsService/getDenunciationAdress()', $th);

            return [
                'http_code' => 500,
                'return'   => ['message' => 'Details denunciations getDenunciationAdress() error']
            ];
        }
    }

    private function getDenunciationUser($denunciation_id)
    {
        try {
            $user = $this->denunciations->select(
                                                'users.name as user_name',
                                                'users.email as user_email',
                                                'users.cpf as user_cpf',
                                                'address.content as address_content',
                                                'neighborhoods.name as neighborhood',
                                                'citys.name as city',
                                                'states.name as state_name',
                                                'states.uf as state_uf'
                                            )
                                        ->leftJoin('users', 'users.id', '=', 'denunciations.user_id')
                                        ->leftJoin('user_address', 'user_address.user_id', '=', 'denunciations.user_id')
                                        ->leftJoin('address', 'address.id', '=', 'user_address.address_id')
                                        ->leftJoin('neighborhoods', 'neighborhoods.id', '=', 'address.neighborhood_id')
                                        ->leftJoin('citys', 'citys.id', '=', 'neighborhoods.city_id')
                                        ->leftJoin('states', 'states.id', '=', 'citys.state_id')
                                        ->where('denunciations.id', $denunciation_id)
                                        ->first()
                                        ->toArray();
            
            if($user !== null){

                if($user['address_content'] != null){
                    $address_content = json_decode($user['address_content']);

                    if($address_content != null){
                        foreach($address_content as $key => $content){
                            $address[$key] = $content;
                            unset($user['address_content']);
                        }
                    } else {
                        unset($user['address_content']);
                    }
                } else {
                    unset($user['address_content']);
                }
                
                return [
                    'http_code' => 200,
                    'return'   => $user
                ]; 

            } else {
                return [
                    'http_code' => 400,
                    'return'   => ['message' => 'User from denunciations details() error']
                ];  
            }
            

        } catch (\Throwable $th) {
            $this->logSystem->log_system_error(500, 'DenunciationsService/getDenunciationUser()', $th);

            return [
                'http_code' => 500,
                'return'   => ['message' => 'Details denunciations getDenunciationUser() error']
            ];
        }
    }

    private function getDenunciationHistoricalStatus($denunciation_id)
    {
        try {
            $historical = $this->historicalStatus->select(
                                            'historical_status.id as historical_id',
                                            'users.name as user_name',
                                            'status.name as status'   
                                        )
                                        ->selectRaw('DATE_FORMAT(historical_status.created_at, "%d/%m/%Y %H:%i:%s") as date')
                                        ->leftJoin('users', 'users.id', '=', 'historical_status.user_id')
                                        ->leftJoin('status', 'status.id', '=', 'historical_status.status_id')
                                        ->where('historical_status.denunciation_id', $denunciation_id)
                                        ->orderBy('historical_status.id', 'DESC')
                                        ->get()
                                        ->toArray();

            if($historical !== null){
                
                return [
                    'http_code' => 200,
                    'return'   => $historical
                ]; 

            } else {
                return [
                    'http_code' => 400,
                    'return'   => ['message' => 'Historical Status from denunciations details() error']
                ];  
            }
            

        } catch (\Throwable $th) {
            $this->logSystem->log_system_error(500, 'DenunciationsService/getDenunciationHistoricalStatus()', $th);

            return [
                'http_code' => 500,
                'return'   => ['message' => 'Details denunciations getDenunciationHistoricalStatus() error']
            ];
        }
    }

    private function getDenunciationContact($denunciation_id)
    {
        try {
            $contact = $this->denunciations->select('user_phones.order as order_phone')
                                           ->selectRaw('REGEXP_REPLACE(phones.number, "([0-9]{2})([0-9]{4,5})([0-9]{4})", "($1) $2-$3") as number')
                                           ->leftJoin('user_phones', 'user_phones.user_id', '=', 'denunciations.user_id')
                                           ->leftJoin('phones', 'phones.id', '=', 'user_phones.phone_id')
                                           ->where('denunciations.id', $denunciation_id)
                                           ->where('user_phones.active', 1)
                                           ->orderBy('user_phones.order', 'ASC')
                                           ->get()
                                           ->toArray();
            
            if($contact !== null){
                
                return [
                    'http_code' => 200,
                    'return'   => $contact
                ]; 

            } else {
                return [
                    'http_code' => 400,
                    'return'   => ['message' => 'Contact from denunciations details() error']
                ];  
            }
            

        } catch (\Throwable $th) {

            $this->logSystem->log_system_error(500, 'DenunciationsService/getDenunciationContact()', $th);

            return [
                'http_code' => 500,
                'return'   => ['message' => 'Details denunciations getDenunciationContact() error']
            ];
        }
    }

    private function getDenunciationDownloadCheck($denunciation_id)
    {
        try {
            $check = $this->denunciations->leftJoin('denunciation_files', 'denunciation_files.denunciation_id', '=', 'denunciations.user_id')
                                         ->where('denunciation_files.denunciation_id', $denunciation_id)
                                         ->count();

            if($check !== null){
                
                return [
                    'http_code' => 200,
                    'return'   => $check > 0 ? true : false
                ]; 

            } else {
                return [
                    'http_code' => 400,
                    'return'   => ['message' => 'Download Check from denunciations details() error']
                ];  
            }
            

        } catch (\Throwable $th) {

            $this->logSystem->log_system_error(500, 'DenunciationsService/getDenunciationDownloadCheck()', $th);

            return [
                'http_code' => 500,
                'return'   => ['message' => 'Details denunciations getDenunciationDownloadCheck() error']
            ];
        }
    }

}
