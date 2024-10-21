<?php

namespace App\Livewire;

use App\Service\FormattingDateService;
use Livewire\Component;

class RequestRoomModal extends Component
{
   public $eventName;
   public $eventDescription;
   public $eventStart;
   public $eventEnd;
    public $showModal = false;

    protected $listeners = [
        "showModal" => "toggleModal",
        "dateSelected" => "dateSelected"
    ];

    public function dateSelected($data): void
    {
        $this->eventStart = app(FormattingDateService::class)->formattingUsingSeparator($data);
//        dd($this->eventStart);
        $this->showModal = !$this->showModal;
    }

    public function toggleModal(): void
    {
        $this->showModal = !$this->showModal;
    }

    public function render()
    {
        return view('livewire.request-room-modal');
    }
}
