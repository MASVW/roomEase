<?php

namespace App\Livewire;

use App\Service\EventService;
use App\Service\FormattingDateService;
use Livewire\Component;

class BookSection extends Component
{
    public $selectedRoom;
    public $id;
    public $upcomingEvent;

    public function mount($id): void
    {
        $this->upcomingEvent = $this->upcomingEvent($id);
    }

    public function formattedDate($date)
    {
        return app(FormattingDateService::class)->formattingDate($date);
    }

    public function upcomingEvent($id)
    {
        return app(EventService::class)->upcomingEvent($id);
    }

    public function ongoingEvent($id): string
    {
        return app(EventService::class)->ongoingEvent($id);
    }

    public function render()
    {
        return view('livewire.book-section');
    }
}
