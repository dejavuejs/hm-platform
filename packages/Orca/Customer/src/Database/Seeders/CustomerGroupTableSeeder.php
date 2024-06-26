<?php

namespace Orca\Customer\Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CustomerGroupTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('customer_groups')->delete();

        DB::table('customer_groups')->insert([
            [
                'id' => 1,
                'code' => 'guest',
                'name' => 'Guest',
                'is_customer_defined' => 0,
            ], [
                'id' => 2,
                'code' => 'general',
                'name' => 'General',
                'is_customer_defined' => 0,
            ], [
                'id' => 3,
                'code' => 'wholesale',
                'name' => 'Wholesale',
                'is_customer_defined' => 0,
            ]
        ]);
    }
}