<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RequestRoomSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Logging\Exception;
use Ramsey\Collection\Collection;
use Tests\TestCase;

class BookingServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
    }
    public function testCreateNewBooking()
    {
        $this->seed(DatabaseSeeder::class);

        $eventName = "Welcoming New Test";
        $eventDescription = "Welcoming for new task for testing this service ~SZ";
        $start = Carbon::now();
        $end = $start->copy()->addDays(5);
        $formattedStart = $start->format('Y-m-d\TH:i');
        $formattedEnd = $end->format('Y-m-d\TH:i');
        $aggrement = true;
        $userId = 1;
        $roomId = 1;

        $service = new \App\Service\BookingService();
        $booking = $service->createBooking($eventName, $eventDescription, $formattedStart, $formattedEnd, $aggrement, $userId, $roomId);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Model::class, $booking);
        $this->assertEquals("Welcoming New Test", $booking->title);
    }

    public function testViewBooking()
    {
        $this->seed(DatabaseSeeder::class);

        $eventName = "Welcoming New Test";
        $eventDescription = "Welcoming for new task for testing this service ~SZ";
        $start = Carbon::now();
        $end = $start->copy()->addDays(5);
        $formattedStart = $start->format('Y-m-d\TH:i');
        $formattedEnd = $end->format('Y-m-d\TH:i');
        $aggrement = true;
        $userId = 1;
        $roomId = 1;

        $service = new \App\Service\BookingService();
        $booking = $service->createBooking($eventName, $eventDescription, $formattedStart, $formattedEnd, $aggrement, $userId, $roomId);

        $viewBooking = $service->viewBooking($booking->id);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Model::class, $viewBooking);
        $this->assertEquals("Welcoming New Test", $viewBooking->title);
    }

    public function testDeleteBooking()
    {
        $this->seed(DatabaseSeeder::class);

        $eventName = "Welcoming New Test";
        $eventDescription = "Welcoming for new task for testing this service ~SZ";
        $start = Carbon::now();
        $end = $start->copy()->addDays(5);
        $formattedStart = $start->format('Y-m-d\TH:i');
        $formattedEnd = $end->format('Y-m-d\TH:i');
        $aggrement = true;
        $userId = 1;
        $roomId = 1;

        $service = new \App\Service\BookingService();
        $booking = $service->createBooking($eventName, $eventDescription, $formattedStart, $formattedEnd, $aggrement, $userId, $roomId);

        $viewBooking = $service->deleteBooking($booking->id);

        $this->assertEquals(true, $viewBooking);
    }



    public function testEditBooking()
    {
        $this->seed(DatabaseSeeder::class);

        $eventName = "Welcoming New Test";
        $eventDescription = "Welcoming for new task for testing this service ~SZ";
        $start = Carbon::now();
        $end = $start->copy()->addDays(5);
        $formattedStart = $start->format('Y-m-d\TH:i');
        $formattedEnd = $end->format('Y-m-d\TH:i');
        $aggrement = true;
        $userId = 1;
        $roomId = 1;

        $service = new \App\Service\BookingService();
        $booking = $service->createBooking($eventName, $eventDescription, $formattedStart, $formattedEnd, $aggrement, $userId, $roomId);

        $updatedEventName = "Welcoming New Student";
        $updatedEventDescription = "Welcoming New Student For 2025";
        $updateBooking = $service->editBooking($booking->id, $updatedEventName, $updatedEventDescription, $formattedStart, $formattedEnd, $userId, $roomId, $status = "approved");

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Model::class, $updateBooking);
        $this->assertEquals("Welcoming New Student", $updateBooking->title);
        $this->assertEquals("Welcoming New Student For 2025", $updateBooking->description);
        $this->assertEquals("approved", $updateBooking->status);
    }

    public function testEditBookingWithInvalidData()
    {
        $this->seed(DatabaseSeeder::class);

        $service = new \App\Service\BookingService();

        $invalidId = 999;
        $this->expectException(\Exception::class);
        $service->editBooking($invalidId, "Invalid Update", "Should fail");
    }
}
