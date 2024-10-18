<?php

namespace App\Livewire;

use App\Models\Calendar;
use App\Models\Room;
use Illuminate\Support\Collection;
use Livewire\Component;

class HeaderComponent extends Component
{
    public $room;

    public function mount(): void
    {
        $this->room = $this->initDataRoom();
    }
    public function initDataRoom(): Collection
    {
        return Room::limit(5)->get();
    }
    public function render()
    {
        return view('livewire.header-component');
    }
}
