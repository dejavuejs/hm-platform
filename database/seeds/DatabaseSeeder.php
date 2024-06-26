<?php

use Illuminate\Database\Seeder;
use Orca\Admin\Database\Seeders\DatabaseSeeder as OrcaDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(OrcaDatabaseSeeder::class);
    }
}
