<?php

namespace App\Livewire;

use App\Models\Room;
use App\Service\CalendarService;
use Livewire\Component;

class CalendarComponent extends Component
{
    public array $data;

    public function render()
    {
        return view('livewire.calendar-component');
    }
}
