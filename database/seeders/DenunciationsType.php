<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DenunciationsType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ["name" => "Descarte irregular de resíduos", 'active' => 1],
            ["name" => "Desmatamento",                   'active' => 1],
            ["name" => "Loteamento irregular",           'active' => 1],
            ["name" => "Uso indevido de área pública",   'active' => 1],
            ["name" => "Maus tratos contra animais",     'active' => 1],
            ["name" => "Abandono de animais",            'active' => 1],
        ];
        
        foreach ($types as $type) {

            DB::table('denunciations_type')->insert([
                'name'        => $type['name'],
                'active'      => $type['active'],
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ]);

        }

    }
}
