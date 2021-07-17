<?php

namespace App\Http\Services\Api\Desktop\Denunciations;

use App\Models\Denunciations;
use App\Models\HistoricalStatus;

use App\Services\Api\LogSystem;

class DenunciationsService
{
    private $denunciations;
    private $historicalStatus;
    private $logSystem;

    public function __construct(
                                    Denunciations $denunciations,
                                    HistoricalStatus $historicalStatus,
                                    LogSystem $logSystem
                               )
    {
        $this->denunciations    = $denunciations;
        $this->historicalStatus = $historicalStatus;
        $this->logSystem        = $logSystem;
    }

    public function list()
    {
        try {
            $denunciations = $this->denunciations->select('denunciations.id', 'denunciations.code', 'denunciations_type.name as type')
                                                ->selectRaw('DATE_FORMAT(denunciations.created_at, "%d/%m/%Y") as day')
                                                ->selectRaw('DATE_FORMAT(denunciations.created_at, "%H:%i") as hour')
                                                ->leftJoin('denunciations_type', 'denunciations_type.id', '=', 'denunciations.denunciations_type_id')
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

}
