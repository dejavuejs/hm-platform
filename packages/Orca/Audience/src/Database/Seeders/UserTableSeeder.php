<?php

namespace Orca\Audience\Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
            [
                'first_name' => 'guest',
                'last_name' => 'Guest',
                'gender' => 0,
                'email' => 'user@orca.com',
                'password' => bcrypt('12345678'),
                'status' => 1,
                'is_verified' => 1,
                'channel_id' => 1,
                'user_group_id' => 1
            ]
        ]);
    }
}