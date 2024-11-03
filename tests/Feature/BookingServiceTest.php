<?php

namespace Tests\Feature;

use App\Models\Calendar;
use App\Models\RequestRoom;
use App\Models\Room;
use App\Models\User;
use App\Service\BookingService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BookingServiceTest extends TestCase
{
    use RefreshDatabase;

    private BookingService $bookingService;
    private User $user;
    private Room $room;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookingService = new BookingService();

        $this->user = User::factory()->create([
            'email' => 'test@example.com'
        ]);

        $this->room = Room::factory()->create();
    }

    public function test_checking_email_with_valid_email()
    {
        $validEmails = [
            'sl@uphroomease.com',
            'ac@uphroomease.com',
            'ga@uphroomease.com'
        ];

        foreach ($validEmails as $email) {
            $this->assertTrue($this->bookingService->checkingEmail($email));
        }
    }

    public function test_checking_email_with_invalid_email()
    {
        $this->assertFalse($this->bookingService->checkingEmail('invalid@example.com'));
    }

    public function test_convert_to_integer_array()
    {
        $this->assertEquals([5], $this->bookingService->convertToIntegerArray(5));

        $this->assertEquals([1, 2, 3], $this->bookingService->convertToIntegerArray('1,2,3'));

        $this->assertEquals([1, 2, 3], $this->bookingService->convertToIntegerArray([1, 2, 3]));
    }

    public function test_create_booking_with_valid_data()
    {
        $user = User::factory()->create(['email' => 'sl@uphroomease.com']);
        Auth::login($user);

        $start = Carbon::today()->setHour(10)->setMinute(0);
        $end = $start->copy()->addHour();

        $data = [
            'eventName' => 'Test Event',
            'eventDescription' => 'Test Description',
            'start' => $start->format('Y-m-d\TH:i'),
            'end' => $end->format('Y-m-d\TH:i'),
            'agreement' => true,
            'userId' => $user->id,
            'roomIds' => [$this->room->id]
        ];

        $booking = $this->bookingService->createBooking(
            $data['eventName'],
            $data['eventDescription'],
            $data['start'],
            $data['end'],
            $data['agreement'],
            $data['userId'],
            $data['roomIds']
        );

        $this->assertNotNull($booking);
        $this->assertEquals('Test Event', $booking->title);
        $this->assertEquals('approved', $booking->status);
        $this->assertDatabaseHas('calendars', [
            'booking_id' => $booking->id,
            'room_id' => $this->room->id
        ]);
    }

    public function test_create_booking_with_invalid_time_range()
    {
        $this->expectException(\Exception::class);

        $user = User::factory()->create(['email' => 'sl@uphroomease.com']);
        Auth::login($user);

        $start = Carbon::today()->setHour(22)->setMinute(0);
        $end = $start->copy()->addHour();

        $this->bookingService->createBooking(
            'Test Event',
            'Test Description',
            $start->format('Y-m-d\TH:i'),
            $end->format('Y-m-d\TH:i'),
            true,
            $user->id,
            [$this->room->id]
        );
    }

    public function test_create_booking_with_invalid_data()
    {
        $this->expectException(\Exception::class);

        $start = Carbon::today()->setHour(10)->setMinute(0);
        $end = $start->copy()->addHour();

        $this->bookingService->createBooking(
            '',
            'Test Description',
            $start->format('Y-m-d\TH:i'),
            $end->format('Y-m-d\TH:i'),
            true,
            $this->user->id,
            [$this->room->id]
        );
    }

    public function test_edit_booking_successfully()
    {
        $start = Carbon::today()->setHour(10)->setMinute(0);
        $end = $start->copy()->addHour();

        $booking = RequestRoom::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'pending',
            'start' => $start,
            'end' => $end
        ]);
        $booking->rooms()->attach($this->room->id);

        $newTitle = 'Updated Event Title';
        $result = $this->bookingService->editBooking(
            $booking->id,
            $newTitle,
            "Halo semuanya ini adalah testing",
            $start->format('Y-m-d\TH:i'),
            $end->format('Y-m-d\TH:i'),
            $this->user->id,
            [$this->room->id],
            'approved'
        );

        $this->assertNotNull($result);
        $this->assertEquals($newTitle, $result->title);
        $this->assertEquals('approved', $result->status);
    }

    public function test_view_booking_successfully()
    {
        $start = Carbon::today()->setHour(10)->setMinute(0);
        $end = $start->copy()->addHour();

        $booking = RequestRoom::factory()->create([
            'user_id' => $this->user->id,
            'start' => $start,
            'end' => $end
        ]);
        $booking->rooms()->attach($this->room->id);

        $result = $this->bookingService->viewBooking($booking->id);

        $this->assertNotNull($result);
        $this->assertEquals($booking->id, $result->id);
        $this->assertTrue($result->rooms->contains($this->room->id));
    }

    public function test_list_pending_bookings()
    {
        $start = Carbon::today()->setHour(10)->setMinute(0);
        $end = $start->copy()->addHour();

        RequestRoom::factory()->count(3)->create([
            'status' => 'pending',
            'user_id' => $this->user->id,
            'start' => $start,
            'end' => $end
        ]);

        RequestRoom::factory()->create([
            'status' => 'approved',
            'user_id' => $this->user->id,
            'start' => $start,
            'end' => $end
        ]);

        $results = $this->bookingService->listBooking();

        $this->assertCount(3, $results);
        $this->assertTrue($results->every(fn($booking) => $booking->status === 'pending'));
    }

    public function test_delete_booking_successfully()
    {
        $start = Carbon::today()->setHour(10)->setMinute(0);
        $end = $start->copy()->addHour();

        $booking = RequestRoom::factory()->create([
            'user_id' => $this->user->id,
            'start' => $start,
            'end' => $end
        ]);
        $booking->rooms()->attach($this->room->id);

        Calendar::factory()->create([
            'booking_id' => $booking->id,
            'room_id' => $this->room->id
        ]);

        $result = $this->bookingService->deleteBooking($booking->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
        $this->assertDatabaseMissing('calendars', ['booking_id' => $booking->id]);
    }

    public function test_cancel_booking_successfully()
    {
        $start = Carbon::today()->setHour(10)->setMinute(0);
        $end = $start->copy()->addHour();

        $booking = RequestRoom::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'approved',
            'start' => $start,
            'end' => $end
        ]);

        Calendar::factory()->create([
            'booking_id' => $booking->id,
            'room_id' => $this->room->id
        ]);

        $result = $this->bookingService->cancelBooking($booking->id);

        $this->assertTrue($result);
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'cancelled'
        ]);
        $this->assertDatabaseMissing('calendars', ['booking_id' => $booking->id]);
    }
}
