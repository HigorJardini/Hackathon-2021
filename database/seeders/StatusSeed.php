<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusAll = [
            ['name' => 'Registro do número de ocorrência',                  'active' => 1, 'order' => 1],
            ['name' => 'Registro do auto de infração - AI',                 'active' => 1, 'order' => 2],
            ['name' => 'Encaminhamento do AI à 2ª. Promotoria de Justiça',  'active' => 1, 'order' => 3],
            ['name' => 'Encaminhamento do AI à 7ª. Promotoria de Justiça',  'active' => 1, 'order' => 4],
            ['name' => 'Encaminhamento do AI à Polícia Civil',              'active' => 1, 'order' => 5],
            ['name' => 'Encaminhamento do AI à Polícia Militar Ambiental',  'active' => 1, 'order' => 6],
            ['name' => 'Encaminhamento do AI à CETESB',                     'active' => 1, 'order' => 7],
            ['name' => 'Não procede',                                       'active' => 1, 'order' => 8],
        ];

        $denuncations = [1,2,3,4,5,6];
        
        foreach($denuncations as $denuncation){
            foreach ($statusAll as $status) {

                DB::table('status')->insert([
                    'denunciations_type_id' => $denuncation,
                    'name'                  => $status['name'],
                    'active'                => $status['active'],
                    'order'                 => $status['order'],
                    'created_at'            => date('Y-m-d H:i:s'),
                    'updated_at'            => date('Y-m-d H:i:s')
                ]);
    
            }
        }
    }
}
