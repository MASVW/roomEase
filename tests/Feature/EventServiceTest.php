<?php

namespace Tests\Unit\Services;

use App\Models\Calendar;
use App\Models\RequestRoom;
use App\Models\Room;
use App\Models\User;
use App\Service\EventService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventServiceTest extends TestCase
{
    use RefreshDatabase;

    private EventService $eventService;
    private Room $room;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventService = new EventService();
        $this->room = Room::factory()->create();
        $this->user = User::factory()->create();
    }

    /**
     * Helper method to create booking and calendar event
     */
    private function createBookingAndEvent(array $calendarData): Calendar
    {
        $booking = RequestRoom::factory()->create([
            'user_id' => $this->user->id,
            'title' => $calendarData['title'],
            'start' => $calendarData['start'],
            'end' => $calendarData['end'],
            'status' => 'approved'
        ]);

        return Calendar::factory()->create([
            'room_id' => $calendarData['room_id'],
            'start' => $calendarData['start'],
            'end' => $calendarData['end'],
            'title' => $calendarData['title'],
            'booking_id' => $booking->id
        ]);
    }

    /**
     * @test
     * @group calendar
     * @group upcoming-events
     */
    public function upcomingEvent_should_return_empty_collection_when_no_future_events_exist()
    {

        $result = $this->eventService->upcomingEvent($this->room->id);

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $result);
        $this->assertTrue($result->isEmpty(), 'Expected collection to be empty when no future events exist');
    }

    /**
     * @test
     * @group calendar
     * @group upcoming-events
     */
    public function upcomingEvent_should_return_only_future_events_in_ascending_order()
    {
        $pastEvent = $this->createBookingAndEvent([
            'start' => Carbon::now()->subDays(2),
            'end' => Carbon::now()->subDay(),
            'title' => 'Past Event',
            'room_id' => $this->room->id
        ]);

        $futureEvent1 = $this->createBookingAndEvent([
            'room_id' => $this->room->id,
            'start' => Carbon::now()->addDays(2),
            'end' => Carbon::now()->addDays(3),
            'title' => 'Future Event 1'
        ]);

        $futureEvent2 = $this->createBookingAndEvent([
            'room_id' => $this->room->id,
            'start' => Carbon::now()->addDay(),
            'end' => Carbon::now()->addDays(2),
            'title' => 'Future Event 2'
        ]);

        $result = $this->eventService->upcomingEvent($this->room->id);

        $this->assertCount(2, $result, 'Expected to return only future events');
        $this->assertEquals($futureEvent2->id, $result->first()->id, 'First event should be the nearest future event');
        $this->assertEquals($futureEvent1->id, $result->last()->id, 'Last event should be the farthest future event');
    }

    /**
     * @test
     * @group calendar
     * @group upcoming-events
     */
    public function upcomingEvent_should_return_events_only_for_specified_room()
    {
        $otherRoom = Room::factory()->create();

        $this->createBookingAndEvent([
            'room_id' => $otherRoom->id,
            'start' => Carbon::now()->addDay(),
            'end' => Carbon::now()->addDays(2),
            'title' => 'Other Room Event'
        ]);

        $targetRoomEvent = $this->createBookingAndEvent([
            'room_id' => $this->room->id,
            'start' => Carbon::now()->addDay(),
            'end' => Carbon::now()->addDays(2),
            'title' => 'Target Room Event'
        ]);

        $result = $this->eventService->upcomingEvent($this->room->id);

        $this->assertCount(1, $result, 'Should only return events for the specified room');
        $this->assertEquals($targetRoomEvent->id, $result->first()->id);
    }

    /**
     * @test
     * @group calendar
     * @group ongoing-events
     */
    public function ongoingEvent_should_return_no_events_message_when_no_current_events()
    {
        $result = $this->eventService->ongoingEvent($this->room->id);

        $this->assertEquals('No Ongoing Events', $result);
    }

    /**
     * @test
     * @group calendar
     * @group ongoing-events
     */
    public function ongoingEvent_should_return_current_title_when_event_is_ongoing()
    {
        $this->createBookingAndEvent([
            'room_id' => $this->room->id,
            'start' => Carbon::now()->subHour(),
            'end' => Carbon::now()->addHour(),
            'title' => 'Current Meeting'
        ]);

        $result = $this->eventService->ongoingEvent($this->room->id);

        $this->assertEquals('Ongoing Event : Current Meeting', $result);
    }

    /**
     * @test
     * @group calendar
     * @group ongoing-events
     */
    public function ongoingEvent_should_not_return_finished_or_future_events()
    {
        $this->createBookingAndEvent([
            'room_id' => $this->room->id,
            'start' => Carbon::now()->subHours(2),
            'end' => Carbon::now()->subHour(),
            'title' => 'Past Meeting'
        ]);

        $this->createBookingAndEvent([
            'room_id' => $this->room->id,
            'start' => Carbon::now()->addHour(),
            'end' => Carbon::now()->addHours(2),
            'title' => 'Future Meeting'
        ]);

        $result = $this->eventService->ongoingEvent($this->room->id);

        $this->assertEquals('No Ongoing Events', $result);
    }

    /**
     * @test
     * @group calendar
     * @group ongoing-events
     */
    public function ongoingEvent_should_return_earliest_event_when_multiple_events_are_ongoing()
    {
        $this->createBookingAndEvent([
            'room_id' => $this->room->id,
            'start' => Carbon::now()->subHours(2),
            'end' => Carbon::now()->addHour(),
            'title' => 'First Ongoing Meeting'
        ]);

        $this->createBookingAndEvent([
            'room_id' => $this->room->id,
            'start' => Carbon::now()->subHour(),
            'end' => Carbon::now()->addHours(2),
            'title' => 'Second Ongoing Meeting'
        ]);

        $result = $this->eventService->ongoingEvent($this->room->id);

        $this->assertEquals('Ongoing Event : First Ongoing Meeting', $result);
    }
}
