<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Calendar>
 */
class CalendarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = Carbon::create(2024, 10, 1);
        $endDate = Carbon::create(2024, 10, 31);

        $randomTimestamp = random_int($startDate->timestamp, $endDate->timestamp);
        $startTime = Carbon::createFromTimestamp($randomTimestamp);

        $endTime = $startTime->copy()->addDays(5);
        return [
            "booking_id" => rand(1,10),
            "event_title" => $this->faker->word(),
            "start" => $startTime,
            "end" => $endTime,
            "room_id" => rand(1,40)
        ];
    }
}
