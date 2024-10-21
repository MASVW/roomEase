<?php

namespace App\Livewire;

use App\Models\RequestRoom;
use App\Service\EventService;
use Carbon\Carbon;
use Livewire\Component;

class RoomListComponent extends Component
{
    public $room;

    public function ongoingEvent($id): string
    {
        return app(EventService::class)->ongoingEvent($id);
    }
    public function render()
    {
        return view('livewire.room-list-component');
    }
}
