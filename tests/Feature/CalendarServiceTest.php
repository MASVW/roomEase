<?php

    namespace Tests\Feature;

    use App\Models\Calendar;
    use App\Models\RequestRoom;
    use App\Models\Room;
    use App\Models\User;
    use App\Service\CalendarService;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Tests\TestCase;
    use Illuminate\Support\Collection;

    class CalendarServiceTest extends TestCase
    {
        use RefreshDatabase;

        private CalendarService $calendarService;
        private Room $room;
        private User $user;

        protected function setUp(): void
        {
            parent::setUp();
            $this->calendarService = new CalendarService();
            $this->room = Room::factory()->create();
            $this->user = User::factory()->create();
        }

        public function test_refresh_data_calendar_has_approved()
        {
            $booking = RequestRoom::factory()->create([
                'title' => 'Test Meeting',
                'start' => '2024-01-01 09:00:00',
                'end' => '2024-01-01 10:00:00',
                'user_id' => $this->user->id,
                'status' => "approved"
            ]);

            Calendar::factory()->create([
                'booking_id' => $booking->id,
                'title' => $booking->title,
                'start' => $booking->start,
                'end' => $booking->end,
                'room_id' => $this->room->id
            ]);

            $result = $this->calendarService->refreshDataCalendarHasApproved();

            $this->assertIsArray($result);
            $this->assertCount(1, $result);
            $this->assertEquals($booking->id, $result[0]['id']);
            $this->assertEquals($booking->title, $result[0]['title']);
            $this->assertEquals($booking->start, $result[0]['start']);
            $this->assertEquals($booking->end, $result[0]['end']);
            $this->assertEquals('#28a745', $result[0]['color']);
        }

        public function test_refresh_data_calendar_specific_room()
        {
            $requestRoom = RequestRoom::factory()->create([
                'title' => 'Test Meeting',
                'start' => '2024-01-01 09:00:00',
                'end' => '2024-01-01 10:00:00',
                'user_id' => $this->user->id,
                'status' => 'pending'
            ]);

            $requestRoom->rooms()->attach($this->room->id);

            $result = $this->calendarService->refreshDataCalendarSpecificRoom($this->room->id);

            $this->assertIsArray($result);
            $this->assertCount(1, $result);
            $this->assertEquals($requestRoom->id, $result[0]['id']);
            $this->assertEquals($requestRoom->title, $result[0]['title']);
            $this->assertEquals($requestRoom->start, $result[0]['start']);
            $this->assertEquals($requestRoom->end, $result[0]['end']);
            $this->assertEquals('#ffc107', $result[0]['color']); // color for pending status
        }

        public function test_get_color_by_status()
        {
            $reflection = new \ReflectionClass($this->calendarService);
            $method = $reflection->getMethod('getColorByStatus');
            $method->setAccessible(true);

            $this->assertEquals('#28a745', $method->invoke($this->calendarService, 'approved'));
            $this->assertEquals('#ffc107', $method->invoke($this->calendarService, 'pending'));
            $this->assertEquals('#dc3545', $method->invoke($this->calendarService, 'rejected'));
            $this->assertEquals('#007bff', $method->invoke($this->calendarService, 'unknown'));
        }

        public function test_init_data_calendar_specific_room_returns_collection()
        {
            $requestRoom = RequestRoom::factory()->create([
                'user_id' => $this->user->id
            ]);
            $requestRoom->rooms()->attach($this->room->id);

            $reflection = new \ReflectionClass($this->calendarService);
            $method = $reflection->getMethod('initDataCalendarSpecificRoom');
            $method->setAccessible(true);

            $result = $method->invoke($this->calendarService, $this->room->id);

            $this->assertInstanceOf(Collection::class, $result);
        }

        public function test_init_data_calendar_has_approved_returns_collection()
        {
            $reflection = new \ReflectionClass($this->calendarService);
            $method = $reflection->getMethod('initDataCalendarHasApproved');
            $method->setAccessible(true);

            $result = $method->invoke($this->calendarService);

            $this->assertInstanceOf(Collection::class, $result);
        }

        public function test_store_data_transforms_data_correctly()
        {
            $requestRoom = RequestRoom::factory()->create([
                'user_id' => $this->user->id,
                'title' => 'Test Meeting',
                'start' => '2024-01-01 09:00:00',
                'end' => '2024-01-01 10:00:00',
                'status' => 'approved'
            ]);
            $collection = new Collection([$requestRoom]);

            $reflection = new \ReflectionClass($this->calendarService);
            $method = $reflection->getMethod('storeData');
            $method->setAccessible(true);

            $result = $method->invoke($this->calendarService, $collection);

            $this->assertIsArray($result);
            $this->assertCount(1, $result);
            $this->assertEquals($requestRoom->id, $result[0]['id']);
            $this->assertEquals('Test Meeting', $result[0]['title']);
            $this->assertEquals('#28a745', $result[0]['color']);
        }
    }
