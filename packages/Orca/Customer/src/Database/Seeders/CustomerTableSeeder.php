<?php

namespace Orca\Customer\Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CustomerTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('customer')->delete();

        DB::table('customer')->insert([
            [
                'first_name' => 'customer',
                'last_name' => 'orca',
                'gender' => 0,
                'email' => 'customer@orca.com',
                'password' => bcrypt('12345678'),
                'status' => 1,
                'is_verified' => 1,
                'channel_id' => 1,
                'customer_group_id' => 1
            ]
        ]);
    }
}