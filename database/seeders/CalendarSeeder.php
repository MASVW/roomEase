<?php

namespace Database\Seeders;

use App\Models\RequestRoom;
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
        $approvedBookings = RequestRoom::with('rooms')->where('status', 'approved')->get();

        foreach ($approvedBookings as $booking) {
            foreach ($booking->rooms as $room) {
                DB::table('calendars')->insert([
                    "booking_id" => $booking->id,
                    "title" => $booking->title,
                    "start" => $booking->start,
                    "end" => $booking->end,
                    "room_id" => $room->id,
                ]);
            }
        }
    }
}
