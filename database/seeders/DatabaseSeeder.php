<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call(BasicAdminPermissionSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(PageSettingSeeder::class);
    }
}
