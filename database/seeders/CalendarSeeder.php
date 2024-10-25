<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $approvedBookings = DB::table('bookings')->where('status', 'approved')->get();

        foreach ($approvedBookings as $booking) {
            DB::table('calendars')->insert([
                "booking_id" => $booking->id,
                "event_title" => $booking->title,
                "start" => $booking->start,
                "end" => $booking->end,
                "room_id" => $booking->room_id,
            ]);
        }
    }
}
