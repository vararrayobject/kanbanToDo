<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('colors')->insert([
            [
                'color' => '#F4F4F4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'color' => '#F8F1FF',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'color' => '#FEF7EF',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'color' => '#EEF7FB',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'color' => '#F4F4FF',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'color' => '#F8E8E8',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'color' => '#EBFDF5',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'color' => '#FFF3E6',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}