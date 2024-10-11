<?php

namespace Database\Seeders;

use Faker\Provider\en_US\Text;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 501; $i <= 510; $i++) {
            DB::table('rooms')->insert([
                'name' => 'LP' . $i,
                'location' => 'LP',
                'capacity' => rand(30, 50),
                'facilities' => Text::randomLetter(100)
            ]);
        };

        for ($i = 601; $i <= 610; $i++) {
            DB::table('rooms')->insert([
                'name' => 'LP' . $i,
                'location' => 'LP',
                'capacity' => rand(30, 50),
                'facilities' => Text::randomLetter(100)
            ]);
        };

        for ($i = 701; $i <= 710; $i++) {
            DB::table('rooms')->insert([
                'name' => 'LP' . $i,
                'location' => 'LP',
                'capacity' => rand(30, 50),
                'facilities' => Text::randomLetter(100)
            ]);
        };

        for ($i = 101; $i <= 110; $i++) {
            DB::table('rooms')->insert([
                'name' => 'AD' . $i,
                'location' => 'AD',
                'capacity' => rand(30, 50),
                'facilities' => Text::randomLetter(100)
            ]);
        };

    }
}
