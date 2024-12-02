<?php
namespace App\Imports;

use App\Models\RequestRoom;
use App\Models\Room;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ScheduleImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $roomName = Str::upper($row['room_name']);

        $room = Room::where('name', $roomName)->firstOrFail();

        $requestRoom  =  new RequestRoom([
            'title' => $row['title'],
            'description' => $row['description'],
            'start' => $row['start'],
            'end' => $row['end'],
            'status' => 'approved',
            'user_id' => auth()->id(),
        ]);

        $requestRoom->save();

        $requestRoom->rooms()->attach($room->id);

        return $requestRoom;
    }

    public function rules(): array
    {
        $validRoomNames = Room::pluck('name')
            ->map(function ($name) {
                return Str::upper($name);
            })
            ->toArray();

        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start' => 'required|date_format:Y-m-d H:i:s',
            'end' => 'required|date_format:Y-m-d H:i:s|after:start',
            'status' => 'nullable|in:pending,approved,rejected',
            'room_name' => [
                'required',
                Rule::in($validRoomNames)
            ]
        ];
    }

    public function customValidationMessages()
    {
        return [
            'title.required' => 'Event title is required',
            'title.max' => 'Event title cannot exceed 255 characters',
            'description.required' => 'Event description is required',
            'start.required' => 'Start time is required',
            'start.date_format' => 'Start time must be in YYYY-MM-DD HH:mm:ss format',
            'end.required' => 'End time is required',
            'end.date_format' => 'End time must be in YYYY-MM-DD HH:mm:ss format',
            'end.after' => 'End time must be after start time',
            'status.in' => 'Status must be either pending, approved, or rejected',
            'room_name.required' => 'Room name is required',
            'room_name.in' => 'Invalid room name. Please check available rooms in the system.'
        ];
    }

    public function prepareForValidation($data, $index)
    {
        if (isset($data['room_name'])) {
            $data['room_name'] = Str::upper($data['room_name']);
        }
        return $data;
    }
}
