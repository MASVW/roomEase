<?php

namespace App\Livewire;

use App\Models\RequestRoom;
use App\Models\User;
use App\Service\BookingService;
use App\Service\FormattingDateService;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DetailBookModal extends Component
{
    public $eventName;
    public $eventDescription;
    public $start;
    public $end;
    public $status;
    public $userNickname;
    public $requestDate;
    public $updatedDate;

    public $showModal = false;
    public $roomId;

    protected $listeners = [
        "eventSelected" => "eventSelected",
    ];

    protected $service;

    public function __construct()
    {
        $this->service = new \stdClass();
        $this->service->formatDate = app(FormattingDateService::class);
    }

    private function resetForm(): void
    {
        $this->eventName = null;
        $this->eventDescription = null;
        $this->start = null;
        $this->end = null;
        $this->userNickname = null;
    }

    public function eventSelected($data): void
    {
        $userId = $data['event']['extendedProps']['user_id'] ?? $data['userId'];
        $this->userNickname = User::findOrFail($userId)->nickname;

        $eventId = $data['event']['id'] ?? $data['eventId'];
        $event = RequestRoom::findOrFail($eventId);
        $this->status = $event->status;
        $this->eventName = $event->title;
        $this->eventDescription = $event->description;
        $this->start = $event->start;
        $this->end = $event->end;
        $this->requestDate = $event->created_at;
        $this->updatedDate = $event->updated_at;
        $this->showModal = !$this->showModal;
    }

    public function toggleModal(): void
    {
        $this->eventName = null;
        $this->eventDescription = null;
        $this->start = null;
        $this->end = null;
        $this->status = null;
        $this->showModal = !$this->showModal;
    }

    public function render()
    {
        return view('livewire.detail-book-modal');
    }
}
