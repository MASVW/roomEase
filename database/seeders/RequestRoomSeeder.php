<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $values = [];
        $status = ['pending', 'approved', 'rejected'];
        for ($i = 0; $i < 10; $i++) {
            $startTime = $faker->dateTime();
            $endTime = $startTime->modify('+5 day');

            $values[] = [
                'title' => $faker->sentence(5),
                "description" => $faker->sentence(10),
                "start_time" => $startTime,
                "end_time" => $endTime,
                "status" => $status[rand(0,2)],
                "user_id" => rand(1,10),
                "room_id" => rand(1,40),
            ];
        }
        DB::table('bookings')->insert($values);
    }
}
