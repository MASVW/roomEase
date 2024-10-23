<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Ramsey\Collection\Collection;
use Tests\TestCase;

class BookingService extends TestCase
{
    use RefreshDatabase;
    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }
    public function testCreateNewBooking()
    {
        $this->seed(DatabaseSeeder::class);

        $eventName = "Welcoming New Test";
        $eventDescription = "Welcoming for new task for testing this service ~SZ";
        $start = Carbon::now();
        $end = $start->addDay(5);
        $aggrement = true;
        $userId = 1;
        $roomId = 1;

        $service = new \App\Service\BookingService();
        $booking = $service->createBooking($eventName, $eventDescription, $start, $end, $aggrement, $userId, $roomId);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Model::class, $booking);
        $this->assertEquals("Welcoming New Test", $booking->title);
    }
}
