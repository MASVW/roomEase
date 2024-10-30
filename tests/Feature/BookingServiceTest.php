<?php

namespace Tests\Feature;

use App\Models\RequestRoom;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RequestRoomSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);

        Auth::login($user);
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
        $agreement = true;
        $userId = auth()->id();
        $userId = 1;
        $roomIds = [1, 2];

        $service = new \App\Service\BookingService();
        $booking = $service->createBooking($eventName, $eventDescription, $formattedStart, $formattedEnd, $agreement, $userId, $roomIds);

        $this->assertInstanceOf(RequestRoom::class, $booking);
        $this->assertEquals("Welcoming New Test", $booking->title);
        $this->assertCount(2, $booking->rooms);
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
        $agreement = true;
        $userId = auth()->id();
        $userId = 1;
        $roomIds = [1, 2];

        $service = new \App\Service\BookingService();
        $booking = $service->createBooking($eventName, $eventDescription, $formattedStart, $formattedEnd, $agreement, $userId, $roomIds);

        $viewBooking = $service->viewBooking($booking->id);

        $this->assertInstanceOf(RequestRoom::class, $viewBooking);
        $this->assertEquals("Welcoming New Test", $viewBooking->title);
        $this->assertCount(2, $viewBooking->rooms); // Check the rooms are correctly attached
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
        $agreement = true;
        $userId = auth()->id();
        $userId = 1;
        $roomIds = [1, 2];

        $service = new \App\Service\BookingService();
        $booking = $service->createBooking($eventName, $eventDescription, $formattedStart, $formattedEnd, $agreement, $userId, $roomIds);

        $deleteBooking = $service->deleteBooking($booking->id);

        $this->assertTrue($deleteBooking);
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
        $agreement = true;
        $userId = auth()->id();
        $userId = 1;
        $roomIds = [1, 2];

        $service = new \App\Service\BookingService();
        $booking = $service->createBooking($eventName, $eventDescription, $formattedStart, $formattedEnd, $agreement, $userId, $roomIds);

        $updatedEventName = "Updated Welcoming Event";
        $updatedEventDescription = "Updated description for the welcoming event.";
        $updatedRoomIds = [2, 3];
        $updateBooking = $service->editBooking($booking->id, $updatedEventName, $updatedEventDescription, $formattedStart, $formattedEnd, $userId, $updatedRoomIds, $status = "approved");

        $this->assertInstanceOf(RequestRoom::class, $updateBooking);
        $this->assertEquals("Updated Welcoming Event", $updateBooking->title);
        $this->assertCount(2, $updateBooking->rooms);
    }

    public function testEditBookingWithInvalidData()
    {
        $this->seed(DatabaseSeeder::class);

        $service = new \App\Service\BookingService();

        $invalidId = 999;
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("The selected id is invalid.");

        $service->editBooking($invalidId, "Invalid Update", "Should fail");
    }
}
