<?php

use Illuminate\Database\Seeder;

class Vendor_Pics_Status_TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vendor_pic_status')->insert([
            'name' => 'Active',
        ]);
        DB::table('vendor_pic_status')->insert([
            'name' => 'Non-Active',
        ]);
    }
}
