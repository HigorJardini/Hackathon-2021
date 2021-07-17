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
    }
}
