<?php

namespace App\Livewire;

use App\Models\Calendar;
use App\Models\Room;
use App\Service\CalendarService;
use Illuminate\Support\Collection;
use Livewire\Component;

class HowToBookPage extends Component
{
    public $data = [];
    public $room;

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
        return Room::limit(5)->get();
    }
    public function render()
    {
        return view('livewire.how-to-book-page');
    }
}
