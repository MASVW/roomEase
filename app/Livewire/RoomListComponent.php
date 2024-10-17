<?php

namespace App\Livewire;

use Livewire\Component;

class RoomListComponent extends Component
{
    public $room;

    public function render()
    {
        return view('livewire.room-list-component');
    }
}
