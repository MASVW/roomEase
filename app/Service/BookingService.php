<?php

namespace App\Service;

use App\Models\RequestRoom;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;
use Tests\TestCase;

class BookingService
{
    public function createBooking($eventName, $eventDescription, $start, $end, $agreement, $userId, $roomId)
    {
        $bookResult = null;
        try {
            DB::transaction(function () use ($eventName, $eventDescription, $start, $end, $agreement, $userId, $roomId, &$bookResult) {
                $requestDetail = [
                    'title' => $eventName,
                    "description" => $eventDescription,
                    "start_time" => $start,
                    "end_time" => $end,
                    "status" => "pending",
                    "user_id" => $userId,
                    "room_id" => $roomId
                ];
                $bookResult = RequestRoom::create($requestDetail);
            });
        } catch (\Exception $e) {
            Log::emergency("Failed to create booking: " . $e->getMessage());
            return null;
        }
        return $bookResult;
    }

    public function editBooking()
    {

    }

    public function vviewBooking()
    {

    }

    public function deleteBooking()
    {

    }

}
