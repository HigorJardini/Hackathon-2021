<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TesteSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('phones')->insert([
            'number'                 => '16998563241',
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ]);

        DB::table('phones')->insert([
            'number'                 => '16997523685',
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ]);
        

        DB::table('denunciations')->insert([
            'user_id'                => 1,
            'phone_id'               => 1,
            'denunciations_type_id'  => 1,
            'code'                   => '1000/2021',
            'description'            => 'Está é uma descrição teste',
            'active'                 => 1,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ]);

        DB::table('denunciations')->insert([
            'user_id'                => 1,
            'phone_id'               => 2,
            'denunciations_type_id'  => 2,
            'code'                   => '1001/2021',
            'description'            => 'Está é uma descrição teste 2',
            'active'                 => 1,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ]);

        DB::table('historical_status')->insert([
            'user_id'                => 1,
            'denunciation_id'        => 1000,
            'status_id'              => 1,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ]);

        DB::table('historical_status')->insert([
            'user_id'                => 1,
            'denunciation_id'        => 1000,
            'status_id'              => 2,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ]);

        DB::table('historical_status')->insert([
            'user_id'                => 1,
            'denunciation_id'        => 1001,
            'status_id'              => 7,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ]);

        DB::table('historical_status')->insert([
            'user_id'                => 1,
            'denunciation_id'        => 1001,
            'status_id'              => 8,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ]);

        DB::table('historical_status')->insert([
            'user_id'                => 1,
            'denunciation_id'        => 1001,
            'status_id'              => 9,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ]);

        DB::table('address')->insert([
            'neighborhood_id'        => 6,
            'content'                => json_encode([
                'zipcode'         => "14406608",
                'street'          => "Rua Paulo Fernandez Carvalho",
                'number_house'    => "960",
                'reference_point' => "Perto de um supermercado"
            ]),
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ]);

        DB::table('address')->insert([
            'neighborhood_id'        => 4,
            'content'                => json_encode([
                'zipcode'         => "14406333",
                'street'          => "Rua Antonez Lileu",
                'number_house'    => "Não Sei",
                'reference_point' => "em frente a uma escola"
            ]),
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ]);

        DB::table('address')->insert([
            'neighborhood_id'        => 2,
            'content'                => json_encode([
                'zipcode'         => "14406000",
                'street'          => "Rua João Carlos",
                'number_house'    => "145",
                'reference_point' => "Ao lado do atacadão"
            ]),
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ]);

        DB::table('denunciation_address')->insert([
            'address_id'             => 1,
            'denunciation_id'        => 1000,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ]);

        DB::table('denunciation_address')->insert([
            'address_id'             => 2,
            'denunciation_id'        => 1001,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ]);

        DB::table('user_address')->insert([
            'user_id'                => 1,
            'address_id'             => 3,
            'active'                 => 1,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ]);

        DB::table('user_phones')->insert([
            'user_id'                => 1,
            'phone_id'               => 1,
            'order'                  => 2,
            'active'                 => 1,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ]);

        DB::table('user_phones')->insert([
            'user_id'                => 1,
            'phone_id'               => 2,
            'order'                  => 1,
            'active'                 => 1,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ]);
    }
}
