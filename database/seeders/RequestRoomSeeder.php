<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        $data = [
            [
                'title' => "Orientation Recap",
                "description" => "A follow-up session for students who missed the orientation activities.",
                "start" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(8, 0),
                "end" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(12, 0),
                "status" => "approved",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "Academic Integrity Workshop",
                "description" => "An event focusing on the importance of academic honesty and integrity.",
                "start" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(9, 0),
                "end" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(11, 0),
                "status" => "approved",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "Faculty Bonding Event",
                "description" => "A casual event for faculty members to strengthen teamwork and collaboration.",
                "start" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(15, 0),
                "end" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(17, 0),
                "status" => "approved",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "Final Project Review Session",
                "description" => "A review session for students presenting their final projects.",
                "start" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(8, 0),
                "end" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(12, 0),
                "status" => "approved",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "Department Meeting",
                "description" => "A regular meeting for department staff and faculty.",
                "start" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(14, 0),
                "end" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(16, 0),
                "status" => "approved",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "Student Leadership Summit",
                "description" => "A summit to develop leadership skills in student organization leaders.",
                "start" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(9, 0),
                "end" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(13, 0),
                "status" => "approved",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "Open House 2024",
                "description" => "An open house event to introduce prospective students to the campus.",
                "start" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(10, 0),
                "end" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(16, 0),
                "status" => "approved",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "Research Seminar",
                "description" => "A seminar where faculty present their latest research.",
                "start" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(13, 0),
                "end" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(15, 0),
                "status" => "approved",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "Workshop on Digital Literacy",
                "description" => "A workshop focusing on the importance of digital literacy.",
                "start" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(10, 0),
                "end" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(12, 0),
                "status" => "approved",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "Campus Cleanup Day",
                "description" => "A volunteer event to clean and beautify the campus.",
                "start" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(8, 0),
                "end" => Carbon::now()->subMonths(rand(1, 3))->subDays(rand(1, 28))->setTime(11, 0),
                "status" => "approved",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "Alumni Gathering",
                "description" => "A reunion event for alumni to reconnect with the university.",
                "start" => Carbon::now()->addDays(rand(5, 30))->setTime(18, 0),
                "end" => Carbon::now()->addDays(rand(5, 30))->setTime(21, 0),
                "status" => "pending",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "Cultural Festival",
                "description" => "A festival to celebrate the cultural diversity on campus.",
                "start" => Carbon::now()->addDays(rand(10, 40))->setTime(10, 0),
                "end" => Carbon::now()->addDays(rand(10, 40))->setTime(20, 0),
                "status" => "pending",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "Guest Lecture: Artificial Intelligence",
                "description" => "A special lecture on the impact of AI in modern industries.",
                "start" => Carbon::now()->addDays(rand(5, 30))->setTime(14, 0),
                "end" => Carbon::now()->addDays(rand(5, 30))->setTime(16, 0),
                "status" => "pending",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "Student Art Exhibition",
                "description" => "An exhibition showcasing artwork created by students.",
                "start" => Carbon::now()->addDays(rand(15, 35))->setTime(9, 0),
                "end" => Carbon::now()->addDays(rand(15, 35))->setTime(17, 0),
                "status" => "pending",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "University Open Day",
                "description" => "An open day for prospective students to explore the campus and programs.",
                "start" => Carbon::now()->addDays(rand(20, 40))->setTime(8, 0),
                "end" => Carbon::now()->addDays(rand(20, 40))->setTime(16, 0),
                "status" => "pending",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "Annual Debate Competition",
                "description" => "An inter-faculty debate competition to sharpen students' critical thinking.",
                "start" => Carbon::now()->addDays(rand(10, 30))->setTime(10, 0),
                "end" => Carbon::now()->addDays(rand(10, 30))->setTime(17, 0),
                "status" => "pending",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "Workshop: Digital Marketing Strategies",
                "description" => "A practical workshop on modern digital marketing techniques.",
                "start" => Carbon::now()->addDays(rand(5, 25))->setTime(9, 0),
                "end" => Carbon::now()->addDays(rand(5, 25))->setTime(15, 0),
                "status" => "pending",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "Charity Run",
                "description" => "A charity event to raise funds for student scholarships.",
                "start" => Carbon::now()->addDays(rand(10, 30))->setTime(6, 0),
                "end" => Carbon::now()->addDays(rand(10, 30))->setTime(10, 0),
                "status" => "pending",
                "user_id" => rand(5, 16)
            ],
            [
                'title' => "Music Concert: Student Band Night",
                "description" => "A concert showcasing performances by student bands.",
                "start" => Carbon::now()->addDays(rand(10, 30))->setTime(19, 0),
                "end" => Carbon::now()->addDays(rand(10, 30))->setTime(22, 0),
                "status" => "pending",
                "user_id" => rand(5, 16)
            ]
        ];
        foreach ($data as $item) {
            $bookingId = DB::table('bookings')->insertGetId($item);
            $rooms = [rand(1, 40), rand(2,40)];

            foreach ($rooms as $roomId) {
                DB::table('booking_room')->insert([
                    'booking_id' => $bookingId,
                    'room_id' => $roomId,
                ]);
            }
        }
    }
}
