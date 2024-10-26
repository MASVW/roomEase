<?php

namespace App\Livewire;

use App\Models\Calendar;
use App\Models\Room;
use App\Service\CalendarService;
use Illuminate\Support\Collection;
use Livewire\Component;

class HomePage extends Component
{
    public $room;
    //TODO: Creating Title For Page
    public $title;
    public $data;

    protected $service;
    public function __construct()
    {
        $this->service = app(CalendarService::class);
    }
    public function mount(): void
    {
        $this->room = $this->initDataRoom();
        $this->data = $this->service->refreshDataCalendarHasApproved();
    }
    public function initDataRoom(): Collection
    {
        return Room::limit(12)->get();
    }
    public function render()
    {
        return view('livewire.home-component');
    }
}
