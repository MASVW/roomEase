<?php

namespace App\Livewire;

use App\Models\Calendar;
use App\Models\RequestRoom;
use App\Models\Room;
use App\Service\BookingService;
use App\Service\CalendarService;
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

    protected $service;


    public function __construct()
    {
        $this->service = app(CalendarService::class);
    }

    public function mount($id)
    {
        $this->roomId = $id;
        $this->data = $this->service->refreshDataCalendarSpecificRoom($this->roomId);

        $this->room = $this->initDataRoom();
        $this->selectedRoom = Room::with('booking')->findOrFail($this->roomId);
    }

    public function initDataRoom(): Collection
    {
        return Room::limit(12)->get();
    }
    public function render()
    {
        return view('livewire.detail-room');
    }
}
