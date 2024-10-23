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

    public function editBooking($id, $eventName, $eventDescription, $start, $end, $agreement, $userId, $roomId, $status)
    {
        $bookResult = null;
        try {
            DB::transaction(function () use ($id, $eventName, $eventDescription, $start, $end, $agreement, $userId, $roomId, $status, &$bookResult) {
                $bookResult = RequestRoom::findOrFail($id);

                $bookResult->title = $eventName;
                $bookResult->description = $eventDescription;
                $bookResult->start_time = $start;
                $bookResult->end_time = $end;
                $bookResult->status = $status;
                $bookResult->user_id = $userId;
                $bookResult->room_id = $roomId;

                $bookResult->save();
                $bookResult->save();
            });
        } catch (\Exception $e) {
            Log::emergency("Failed to edit booking: " . $e->getMessage());
            return null;
        }
        return $bookResult;
    }

    public function viewBooking($id)
    {
        $bookResult = null;
        try {
            DB::transaction(function () use ($id, &$bookResult) {
                $bookResult = RequestRoom::findOrFail($id);
                return $bookResult;
            });
        } catch (\Exception $e) {
            Log::emergency("Failed to view booking: " . $e->getMessage());
            return null;
        }
        return $bookResult;
    }

    public function deleteBooking($id)
    {
        $deletedCount = 0;
        try {
            $deletedCount = DB::transaction(function () use ($id) {
                return RequestRoom::destroy($id);
            });
        } catch (\Exception $e) {
            Log::emergency("Failed to delete booking: " . $e->getMessage());
            return false;
        }
        return $deletedCount > 0;
    }

}
