<?php

namespace App\Livewire;

use Livewire\Component;

class RoomInsightComponent extends Component
{
    public $room;
    public $data;

    public function mount($room)
    {
        $this->room = $room;
    }
    public function render()
    {
        return view('livewire.room-insight-component');
    }
}
