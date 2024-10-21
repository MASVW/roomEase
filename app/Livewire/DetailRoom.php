<?php

namespace App\Livewire;

use App\Models\Calendar;
use App\Models\Room;
use App\Service\EventService;
use Illuminate\Support\Collection;
use Livewire\Component;

class DetailRoom extends Component
{
    public $room;
    public $roomId;

    public $selectedRoom;

    public $data;

    public function mount($id)
    {
        $this->roomId = $id;
        $initData = $this->initDataCalendar($id);
        $this->storeData($initData);

        $this->selectedRoom = Room::with('booking')->findOrFail($id);
        $this->room = $this->initDataRoom();
    }

    public function initDataRoom(): Collection
    {
    return Room::limit(12)->get();
    }
    public function initDataCalendar($id): Collection
    {
        return Calendar::where('room_id', $id)->with('booking.user')->get();
    }

    public function storeData($data): void
    {
        foreach($data as $item)
        {
            $this->data[] = [
                'title' => $item->event_title,
                'start' => $item->start,
                'end' => $item->end,
            ];
        }
    }


    public function render()
    {
        return view('livewire.detail-room');
    }
}
