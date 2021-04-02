<?php

namespace Orca\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Orca\Category\Database\Seeders\DatabaseSeeder as CategorySeeder;
use Orca\Attribute\Database\Seeders\DatabaseSeeder as AttributeSeeder;
use Orca\Core\Database\Seeders\DatabaseSeeder as CoreSeeder;
use Orca\User\Database\Seeders\DatabaseSeeder as UserSeeder;
use Orca\Audience\Database\Seeders\DatabaseSeeder as AudienceSeeder;
use Orca\Inventory\Database\Seeders\DatabaseSeeder as InventorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySeeder::class);
        // $this->call(InventorySeeder::class);
        $this->call(CoreSeeder::class);
        // $this->call(AttributeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AudienceSeeder::class);
    }
}
