<?php

namespace App\Http\Services\Api\Desktop\Dashboard;

use App\Models\User;

use App\Services\Api\LogSystem;
use Illuminate\Support\Facades\Validator;
use App\Models\HistoricalStatus;

use Illuminate\Support\Facades\DB;

class DashboardService
{
    private $users;
    private $logSystem;

    public function __construct(
                                    User $users,
                                    LogSystem $logSystem
                               )
    {
        $this->users      = $users;
        $this->logSystem  = $logSystem;
    }

    public function home($year = null)
    {
        try {
            if($year != null)
                $year_content = "WHERE YEAR(created_at) = $year";
            else
                $year_content = "";

            $dash1 = DB::select("
                SELECT MONTH(created_at) as 'name', SUM(1) as Quantidade
                FROM denunciations
                $year_content
                GROUP BY MONTH(created_at)
                ORDER BY MONTH(created_at) ASC;
            ");

            $dash2 = DB::select("SELECT dy.id, dy.name as name, COUNT(d.denunciations_type_id) as 'value'
                                 FROM denunciations as d
                                 LEFT JOIN denunciations_type AS dy ON dy.id = d.denunciations_type_id
                                 GROUP BY d.denunciations_type_id;
                               ");

            $types = DB::select("SELECT d.id, d.name as name
                                            FROM denunciations_type as d;
                               ");
            
            $dash2_content = [];

            foreach($types as $key => $type){
                $dash2_content[$key]['name']  = $type->name;
                $dash2_content[$key]['value'] = 0;
                foreach($dash2 as $current){
                    if($type->id == $current->id)
                        $dash2_content[$key]['value'] = $current->value;
                }
            }

            $list_months = [1,2,3,4,5,6,7,8,9,10,11,12];

            $dash1_content = [];

            foreach($list_months as $key => $month){
                $dash1_content[$key]['name'] = $month;
                $dash1_content[$key]['Quantidade'] = 0;
                foreach($dash1 as $current){
                    if($month == $current->name)
                        $dash1_content[$key]['Quantidade'] = (integer) $current->Quantidade;
                }
            }

            return [
                'http_code' => 200,
                'return'   => [
                    'dash1' => $dash1_content,
                    'dash2' => $dash2_content
                ]
            ]; 

        } catch (\Throwable $th) {
            
            DB::rollBack();

            $this->logSystem->log_system_error(500, 'DashboardService/home()', $th);
            
            return [
                'http_code' => 500,
                'return'   => ['message' => 'Dashboard error']
            ]; 
        }

    }



}
