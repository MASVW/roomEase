<?php

namespace App\Livewire;

use App\Models\Room;
use App\Service\CalendarService;
use Livewire\Component;

class CalendarComponent extends Component
{
    public $room;
    public $roomId;

    public array $data;

    protected $listeners = ['roomRequestCreated' => 'refreshData'];

    protected $service;

    public function render()
    {
        return view('livewire.calendar-component');
    }
}
