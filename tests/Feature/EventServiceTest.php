<?php

namespace Tests\Feature;

use App\Models\Calendar;
use App\Models\RequestRoom;
use App\Models\Room;
use App\Models\User;
use App\Service\EventService;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RequestRoomSeeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class EventServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;
    public function testUpcomingEventReturnsEmptyCollectionWhenNoEvents()
    {
        $service = new EventService();
        $result = $service->upcomingEvent(1);

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $result);
        $this->assertTrue($result->isEmpty());
    }

    public function testUpcomingEventReturnsEvents()
    {
        $this->seed(DatabaseSeeder::class);
        $room_id = 1;

        $requestRoomTicket = 1;
        $event = Calendar::create([
            'room_id' => $room_id,
            'start' => Carbon::now()->addDay(),
            'end' => Carbon::now()->addDays(2),
            'booking_id' => $requestRoomTicket,
            'event_title' => 'Welcoming New Student'
        ]);

        $service = new EventService();
        $result = $service->upcomingEvent($room_id);

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $result);
        $this->assertFalse($result->isEmpty());
        $this->assertTrue($result->first()->is($event));
    }

    public function testOngoingEventReturnsNoOngoingEvents()
    {
        $service = new EventService();
        $result = $service->ongoingEvent(1);

        $this->assertEquals('No Ongoing Events', $result);
    }

    public function testOngoingEventReturnsOngoingEvent()
    {
        $user = User::factory()->create();
        $room = Room::factory()->create();

        $booking = RequestRoom::factory()->create([
            'title' => 'Welcoming New Student',
            'description' => 'Welcoming New Student',
            'user_id' => $user->id,
            'room_id' => $room->id,
            'start_time' => Carbon::now()->subHour(),
            'end_time' => Carbon::now()->addHour(),
            'status' => 'approved'
        ]);

        $event = Calendar::factory()->create([
            'room_id' => $room->id,
            'start' => $booking->start_time,
            'end' => $booking->end_time,
            'booking_id' => $booking->id,
            'event_title' => 'Welcoming New Student'
        ]);

        $service = new EventService();
        $result = $service->ongoingEvent($room->id);

        $this->assertEquals('Ongoing Event : Welcoming New Student', $result);
    }
}
