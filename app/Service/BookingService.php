<?php

namespace App\Service;

use App\Models\RequestRoom;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;
use Tests\TestCase;

class BookingService
{
    protected function validateBookingData($data, $rules)
    {
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }
    public function createBooking($eventName, $eventDescription, $start, $end, $agreement, $userId, $roomId)
    {
        $bookResult = null;

        $data = [
            'eventName' => $eventName,
            'eventDescription' => $eventDescription,
            'start' => $start,
            'end' => $end,
            'agreement' => $agreement,
            'userId' => $userId,
            'roomId' => $roomId
        ];

        $rules = [
            'eventName' => 'required|string|max:255',
            'eventDescription' => 'required|string|max:1000',
            'start' => 'required|date_format:Y-m-d\TH:i|before:end',
            'end' => 'required|date_format:Y-m-d\TH:i|after:start',
            'agreement' => 'required|boolean',
            'roomId' => 'required|integer|exists:rooms,id',
        ];

        $this->validateBookingData($data, $rules);

        try {
            DB::transaction(function () use ($data, &$bookResult) {
                $requestDetail = [
                    'title' => $data['eventName'],
                    "description" => $data['eventDescription'],
                    "start" => $data['start'],
                    "end" => $data['end'],
                    "status" => "pending",
                    "user_id" => $data['userId'],
                    "room_id" => $data['roomId']
                ];
                $bookResult = RequestRoom::create($requestDetail);
            });
        } catch (\Exception $e) {
            Log::emergency("Failed to create booking: " . $e->getMessage());
            return null;
        }
        return $bookResult;
    }

    public function editBooking($id, $eventName = null, $eventDescription = null, $start = null, $end = null, $userId = null, $roomId = null, $status = null)
    {
        $bookResult = null;

        $data = [
            'id' => $id,
            'eventName' => $eventName,
            'eventDescription' => $eventDescription,
            'start' => $start,
            'end' => $end,
            'userId' => $userId,
            'roomId' => $roomId,
            'status' => $status
        ];

        $rules = [
            'id' => 'required|integer|exists:bookings,id',
            'eventName' => 'sometimes|string|max:255',
            'eventDescription' => 'sometimes|string|max:1000',
            'start' => 'sometimes|date_format:Y-m-d\TH:i|before:end',
            'end' => 'sometimes|date_format:Y-m-d\TH:i|after:start',
            'userId' => 'sometimes|integer|exists:users,id',
            'roomId' => 'sometimes|integer|exists:rooms,id',
            'status' => 'sometimes|in:pending,approved,rejected,cancelled'
        ];

        $this->validateBookingData($data, $rules);

        try {
            DB::transaction(function () use ($data, &$bookResult) {
                $bookResult = RequestRoom::findOrFail($data['id']);

                foreach ($data as $key => $value) {
                    if ($key != 'id') {  // Avoid changing the ID
                        $attribute = match ($key) {
                            'eventName' => 'title',
                            'eventDescription' => 'description',
                            'start' => 'start',
                            'end' => 'end',
                            'userId' => 'user_id',
                            'roomId' => 'room_id',
                            'status' => 'status',
                            default => null
                        };

                        if ($attribute) {
                            $bookResult->$attribute = $value;
                        }
                    }
                }

                $bookResult->save();
            });
        } catch (ModelNotFoundException $e) {
            Log::emergency("Failed to edit booking: " . $e->getMessage());
            return null;
        }
        return $bookResult;
    }

    public function viewBooking($id)
    {
        $bookResult = null;

        $data = [
            'id' => $id,
        ];

        $rules = [
            'id' => 'required|integer|exists:bookings,id',
        ];

        $this->validateBookingData($data, $rules);

        try {
            DB::transaction(function () use ($data, &$bookResult) {
                $bookResult = RequestRoom::findOrFail($data['id']);
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

        $data = [
            'id' => $id,
        ];

        $rules = [
            'id' => 'required|integer|exists:bookings,id',
        ];

        $this->validateBookingData($data, $rules);

        try {
            $deletedCount = DB::transaction(function () use ($data) {
                return RequestRoom::destroy($data['id']);
            });
        } catch (\Exception $e) {
            Log::emergency("Failed to delete booking: " . $e->getMessage());
            return false;
        }
        return $deletedCount > 0;
    }

}
