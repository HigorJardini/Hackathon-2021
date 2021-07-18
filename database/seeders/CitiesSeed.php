<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\States;
use Illuminate\Support\Facades\DB;

class CitiesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = $this->cities();
        foreach ($cities as $citie){
            DB::table('citys')->insert([
                'id'         => $citie['id'],
                'state_id'   => $citie['state_id'],
                'name'       => $citie['name'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    private function cities(){
        return [
            [
                "id" => 3516200,
                "state_id" => 35,
                "name" => "Franca",
                "active" => 1
            ]
        ];
    }

    

}