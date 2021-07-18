<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
            ['ibge'=> 11,'name'=> 'Rondônia',            'uf' => 'RO', 'active' => 0],
            ['ibge'=> 12,'name'=> 'Acre',                'uf' => 'AC', 'active' => 0],
            ['ibge'=> 13,'name'=> 'Amazonas',            'uf' => 'AM', 'active' => 0],
            ['ibge'=> 14,'name'=> 'Roraima',             'uf' => 'RR', 'active' => 0],
            ['ibge'=> 15,'name'=> 'Pará',                'uf' => 'PA', 'active' => 0],
            ['ibge'=> 16,'name'=> 'Amapá',               'uf' => 'AP', 'active' => 0],
            ['ibge'=> 17,'name'=> 'Tocantins',           'uf' => 'TO', 'active' => 0],
            ['ibge'=> 21,'name'=> 'Maranhão',            'uf' => 'MA', 'active' => 0],
            ['ibge'=> 22,'name'=> 'Piauí',               'uf' => 'PI', 'active' => 0],
            ['ibge'=> 23,'name'=> 'Ceará',               'uf' => 'CE', 'active' => 0],
            ['ibge'=> 24,'name'=> 'Rio Grande do Norte', 'uf' => 'RN', 'active' => 0],
            ['ibge'=> 25,'name'=> 'Paraíba',             'uf' => 'PB', 'active' => 0],
            ['ibge'=> 26,'name'=> 'Pernambuco',          'uf' => 'PE', 'active' => 0],
            ['ibge'=> 27,'name'=> 'Alagoas',             'uf' => 'AL', 'active' => 0],
            ['ibge'=> 28,'name'=> 'Sergipe',             'uf' => 'SE', 'active' => 0],
            ['ibge'=> 29,'name'=> 'Bahia',               'uf' => 'BA', 'active' => 0],
            ['ibge'=> 31,'name'=> 'Minas Gerais',        'uf' => 'MG', 'active' => 0],
            ['ibge'=> 32,'name'=> 'Espírito Santo',      'uf' => 'ES', 'active' => 0],
            ['ibge'=> 33,'name'=> 'Rio de Janeiro',      'uf' => 'RJ', 'active' => 0],
            ['ibge'=> 35,'name'=> 'São Paulo',           'uf' => 'SP', 'active' => 1],
            ['ibge'=> 41,'name'=> 'Paraná',              'uf' => 'PR', 'active' => 0],
            ['ibge'=> 42,'name'=> 'Santa Catarina',      'uf' => 'SC', 'active' => 0],
            ['ibge'=> 43,'name'=> 'Rio Grande do Sul',   'uf' => 'RS', 'active' => 0],
            ['ibge'=> 50,'name'=> 'Mato Grosso do Sul',  'uf' => 'MS', 'active' => 0],
            ['ibge'=> 51,'name'=> 'Mato Grosso',         'uf' => 'MT', 'active' => 0],
            ['ibge'=> 52,'name'=> 'Goiás',               'uf' => 'GO', 'active' => 0],
            ['ibge'=> 53,'name'=> 'Distrito Federal',    'uf' => 'DF', 'active' => 0]
          ];

          foreach ($states as $state){
            DB::table('states')->insert([
                'id'           => $state['ibge'],
                'ibge'         => $state['ibge'],
                'name'         => $state['name'],
                'uf'           => $state['uf'],
                'active'       => $state['active'],
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
          }

    }
}
