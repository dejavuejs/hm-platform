<?php

namespace Orca\User\Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AdminsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->delete();

        DB::table('admins')->insert([
                'id' => 1,
                'name' => 'Admin example',
                'email' => 'admin@example.com',
                'password' => bcrypt('12345678'),
                'status' => 1,
                'role_id' => 1,
            ]);
    }
}
