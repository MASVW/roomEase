<?php

namespace App\Livewire;

use App\Models\RequestRoom;
use Carbon\Carbon;
use Livewire\Component;

class RoomListComponent extends Component
{
    public $room;

    public function upcomingEvent($id): string
    {
        $nextBooking = RequestRoom::where('room_id', $id)
            ->where('status', 'approved')
            ->where('end_time', '>', Carbon::now())
            ->orderBy('end_time', 'asc')
            ->first();

        if ($nextBooking) {
            return "Booked At " . $nextBooking->end_time->format('d M');
        }

        return "No Upcoming Events";
    }
    public function render()
    {
        return view('livewire.room-list-component');
    }
}
