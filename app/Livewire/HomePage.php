<?php

namespace App\Livewire;

use App\Models\Calendar;
use App\Models\Room;
use App\Service\CalendarService;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class HomePage extends Component
{
    public $title;
    public $data;
    #[Url(history: true)]
    public $search = '';

    protected CalendarService $service;

    public function boot(CalendarService $service)
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        $this->data = $this->service->refreshDataCalendarHasApproved();
    }

    #[On('searchUpdated')]
    public function updateSearch($search): void
    {
        $this->search = $search;
    }

    public function render()
    {
        return view('livewire.home-component');
    }
}
