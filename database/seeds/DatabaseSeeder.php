<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(IndustrysTableSeeder::class);
        $this->call(Vendor_Status_TableSeeder::class);
        $this->call(Vendor_Pics_Status_TableSeeder::class);
    }
}
