<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserAdminSeeder::class,
            DenunciationsType::class,
            StatusSeed::class,
            StatesSeed::class,
            CitiesSeed::class,
            NeighborhoodsSeed::class,
            // TesteSeed::class
        ]);

    }
}
