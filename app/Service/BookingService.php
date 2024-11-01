<?php

namespace App\Service;

use App\Models\Calendar;
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

    public function checkingEmail($email)
    {
        $validEmails = [
            'sl@uphroomease.com',
            'ac@uphroomease.com',
            'ga@uphroomease.com'
        ];

        if (in_array($email, $validEmails)) {
        return true;
        }

        return false;
    }

    function convertToIntegerArray($input) {
        if (is_int($input)) {
            return [$input];
        } elseif (is_string($input)) {
            return array_map('intval', explode(',', $input));
        } elseif (is_array($input))
        return $input;
    }

    public function createBooking($eventName, $eventDescription, $start, $end, $agreement, $userId, $roomIds)
    {
        $status = $this->checkingEmail(auth()->user()->email) ? "approved" : "pending";
        $bookResult = null;
        $formattedRoomId = $this->convertToIntegerArray($roomIds);

        $data = [
            'eventName' => $eventName,
            'eventDescription' => $eventDescription,
            'start' => $start,
            'end' => $end,
            'agreement' => $agreement,
            'userId' => $userId,
            'roomIds' => $formattedRoomId
        ];

        $rules = [
            'eventName' => 'required|string|max:255',
            'eventDescription' => 'required|string|max:1000',
            'start' => 'required|date_format:Y-m-d\TH:i|before:end|time_range',
            'end' => 'required|date_format:Y-m-d\TH:i|after:start|time_range',
            'agreement' => 'required|boolean',
            'userId' => 'required|integer|exists:users,id',
            'roomIds' => 'required|array',
            'roomIds.*' => 'integer|exists:rooms,id'
        ];

        $this->validateBookingData($data, $rules);

        try {
            DB::transaction(function () use ($data, &$bookResult, $status) {
                $requestDetail = [
                    'title' => $data['eventName'],
                    "description" => $data['eventDescription'],
                    "start" => $data['start'],
                    "end" => $data['end'],
                    "status" => $status,
                    "user_id" => $data['userId']
                ];

                $bookResult = RequestRoom::create($requestDetail);
                $bookResult->rooms()->attach($data['roomIds']);

                if ($status == "approved") {
                    foreach ($data['roomIds'] as $roomId) {
                        Calendar::create([
                            'title' => $bookResult->title,
                            'start' => $bookResult->start,
                            'end' => $bookResult->end,
                            'booking_id' => $bookResult->id,
                            'room_id' => $roomId
                        ]);
                    }
                }
            });
        } catch (\Exception $e) {
            Log::emergency("Failed to create booking: " . $e->getMessage());
            return null;
        }
        return $bookResult;
    }

    public function editBooking($id, $eventName = null, $eventDescription = null, $start = null, $end = null, $userId = null, $roomIds = null, $status = null)
    {
        $bookResult = null;

        $data = [
            'id' => $id,
            'eventName' => $eventName,
            'eventDescription' => $eventDescription,
            'start' => $start,
            'end' => $end,
            'userId' => $userId,
            'roomIds' => $roomIds,
            'status' => $status
        ];

        $rules = [
            'id' => 'required|integer|exists:bookings,id',
            'eventName' => 'sometimes|required|string|max:255',
            'eventDescription' => 'sometimes|required|string|max:1000',
            'start' => 'sometimes|required|date_format:Y-m-d\TH:i|before:end',
            'end' => 'sometimes|required|date_format:Y-m-d\TH:i|after:start',
            'userId' => 'sometimes|required|integer|exists:users,id',
            'roomIds' => 'sometimes|required|array',
            'roomIds.*' => 'integer|exists:rooms,id',
            'status' => 'sometimes|required|in:pending,approved,rejected,cancelled'
        ];

        $this->validateBookingData($data, $rules);

        try {
            DB::transaction(function () use ($data, &$bookResult) {
                $bookResult = RequestRoom::findOrFail($data['id']);

                $attributesToUpdate = [
                    'title' => $data['eventName'],
                    'description' => $data['eventDescription'],
                    'start' => $data['start'],
                    'end' => $data['end'],
                    'user_id' => $data['userId'],
                    'status' => $data['status'],
                ];

                // Filter null values from data to only update provided fields
                $attributesToUpdate = array_filter($attributesToUpdate, function ($value) {
                    return !is_null($value);
                });

                $bookResult->update($attributesToUpdate);

                // Update rooms if provided
                if (isset($data['roomIds'])) {
                    $bookResult->rooms()->sync($data['roomIds']);
                }
            });
        } catch (ModelNotFoundException $e) {
            Log::emergency("Failed to edit booking: " . $e->getMessage());
            return null;
        }
        return $bookResult;
    }


    public function viewBooking($id)
    {
        try {
            $booking = RequestRoom::with('rooms')->findOrFail($id);
            return $booking;
        } catch (\Exception $e) {
            Log::error("Failed to view booking: " . $e->getMessage());
            return null;
        }
    }

    public function listBooking()
    {
        try {
            $bookings = RequestRoom::with('rooms')->where('status', 'pending')->get();
            return $bookings;
        } catch (\Exception $e) {
            Log::error("Failed to list bookings: " . $e->getMessage());
            return null;
        }
    }

    public function deleteBooking($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $booking = RequestRoom::findOrFail($id);
                $booking->rooms()->detach();

                Calendar::where('booking_id', $id)->delete();
                $booking->delete();
            });
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to delete booking: " . $e->getMessage());
            return false;
        }
    }

    public function cancelBooking($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $booking = RequestRoom::findOrFail($id);
                $booking->update(['status' => 'cancelled']);
                Calendar::where('booking_id', $id)->delete();
            });
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to cancel booking: " . $e->getMessage());
            return false;
        }
    }

}
