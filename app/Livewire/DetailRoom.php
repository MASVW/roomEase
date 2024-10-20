<?php

namespace App\Livewire;

use App\Models\Room;
use Illuminate\Support\Collection;
use Livewire\Component;

class DetailRoom extends Component
{
    public $room;

    public $selectedRoom;

    public $data;

    public function mount($id)
    {
        $this->selectedRoom = Room::findOrFail($id);
        $this->room = $this->initDataRoom();
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
