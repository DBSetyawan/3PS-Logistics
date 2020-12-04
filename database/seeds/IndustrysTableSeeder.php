<?php

use Illuminate\Database\Seeder;

class IndustrysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('industrys')->insert([
            'industry' => 'Logistics',
        ]);
        DB::table('industrys')->insert([
            'industry' => 'FMCG',
        ]);
    }
}
