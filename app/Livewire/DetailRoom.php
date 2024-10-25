<?php

namespace App\Livewire;

use App\Models\Calendar;
use App\Models\RequestRoom;
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

    protected $listeners = ['roomRequestCreated' => 'refreshData'];

    public function mount($id)
    {
        $this->roomId = $id;
        $this->refreshData();
    }

    public function refreshData(): void
    {
        $initData = $this->initDataCalendar($this->roomId);
        $this->storeData($initData);

        $this->selectedRoom = Room::with('booking')->findOrFail($this->roomId);
        $this->room = $this->initDataRoom();
    }

    public function initDataRoom(): Collection
    {
    return Room::limit(12)->get();
    }
    public function initDataCalendar($id): Collection
    {
        return RequestRoom::where('room_id', $id)->get();
//        return Calendar::where('room_id', $id)->with('booking.user')->get();
    }

    public function storeData($data): void
    {
        foreach($data as $item)
        {
            $this->data[] = [
                'title' => $item->title,
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
