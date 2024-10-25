<?php

namespace App\Livewire;

use App\Service\BookingService;
use App\Service\FormattingDateService;
use App\Service\ValidateService;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RequestRoomModal extends Component
{
    #[Validate('required|string|min:3|max:255|')]
   public $eventName;
    #[Validate('required|string|min:10|max:3000|')]
   public $eventDescription;
    #[Validate('required|date_format:Y-m-d\TH:i|before:end')]
    public $start;
    #[Validate('required|date_format:Y-m-d\TH:i|after:start')]
    public $end;
    public $agreement = false;
    public $showModal = false;
    public $roomId;

    protected $listeners = [
        "showModal" => "toggleModal",
        "dateSelected" => "dateSelected"
    ];

    protected $service;

    public function __construct()
    {
        $this->service = new \stdClass();
        $this->service->formatDate = app(FormattingDateService::class);
        $this->service->reservationRequest = app(BookingService::class);
    }

    /**
     * Reset the form inputs.
     */
    private function resetForm(): void
    {
        $this->eventName = null;
        $this->eventDescription = null;
        $this->start = null;
        $this->end = null;
        $this->agreement = null;
    }

    public function dateSelected($data): void
    {
        $this->start = $this->service->formatDate->formattingUsingSeparator($data['startStr']);
        $this->end = $this->service->formatDate->formattingUsingSeparator($data['endStr']);
        $this->showModal = !$this->showModal;
    }

    public function toggleModal(): void
    {
        $this->start = null;
        $this->end = null;
        $this->showModal = !$this->showModal;
    }
    public function submit()
    {
        $this->validate();

        if (!$this->agreement) {
            throw ValidationException::withMessages([
                'agreement' => 'You must agree to the terms and conditions.',
            ]);
        }

        $userId = auth()->id() ?? 1;

        try {
            $data = $this->service->reservationRequest->createBooking(
                $this->eventName,
                $this->eventDescription,
                $this->start,
                $this->end,
                $this->agreement,
                $userId,
                $this->roomId
            );

            if ($data) {
                Notification::make()
                    ->title('Reservation Submitted Successfully')
                    ->body('Your room reservation request has been submitted and is under review.')
                    ->success()
                    ->send();

                $this->resetForm();

                $this->toggleModal();

                return redirect(request()->header('Referer'));
            }
        } catch (\Exception $e) {
            Log::error('Reservation submission failed', ['error' => $e->getMessage()]);

            Notification::make()
                ->title('Reservation Submission Failed')
                ->body('There was an issue processing your request. Please try again or contact support if the issue persists.')
                ->danger()
                ->send();
        }

        $this->toggleModal();
    }


    public function render()
    {
        return view('livewire.request-room-modal');
    }
}
