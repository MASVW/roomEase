<?php

namespace App\Livewire;

use App\Models\RequestRoom;
use App\Models\Room;
use App\Service\BookingService;
use App\Service\FormattingDateService;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class ApplicationPage extends Component
{
    use WithPagination;
    public $userId;
    protected $service;
    protected $bookingService;

//    FOR EDIT
    #[Validate('required|string|min:3|max:255|')]
    public $eventName;
    #[Validate('required|string|min:10|max:3000|')]
    public $eventDescription;
    #[Validate('required|date_format:Y-m-d\TH:i|before:end|time_range')]
    public $start;
    #[Validate('required|date_format:Y-m-d\TH:i|after:start|time_range')]
    public $end;
    public $bookingId;
    #[Validate('required|accepted')]
    public $agreement = true;
    public $roomId =[];
    public $status;
    public $showModal = false;
    public $modalDeletion = false;
    public $modalCancel = false;

    public $bookIdSelected;

    public function __construct()
    {
        $this->bookingService = app(BookingService::class);
        $this->service = app(FormattingDateService::class);
    }

    public function mount($id)
    {
        $this->userId = $id;
    }

    public function eventDuration($eventStart, $eventEnd)
    {
        $start = Carbon::parse($eventStart)->startOfDay();
        $end = Carbon::parse($eventEnd)->endOfDay();

        if ($start->isSameDay($end)) {
            $hours = Carbon::parse($eventStart)->diffInHours($eventEnd);
            $duration = "($hours Hours)";
        } else {
            $startTime = Carbon::parse($eventStart);
            $endTime = Carbon::parse($eventEnd);
            $days = $startTime->diffInDays($endTime) + 1;
            $formatted = number_format($days, 0);
            $duration = "({$formatted} Days)";
        }
        return  $start->format('d M Y') . ' ' . $duration;
    }

    public function bookingSelected($id)
    {
        $data = [
            'userId' => auth()->user()->id,
            'eventId' => $id
        ];
        $this->dispatch('eventSelected', $data)->to(DetailBookModal::class);
    }

    public function editBooking($id)
    {
        $event = RequestRoom::findOrFail($id);
        $roomIds = $event->rooms->pluck('id')->toArray();
        $this->bookingId = $event['id'];
        $this->eventName = $event['title'];
        $this->eventDescription = $event['description'];
        $formatedStart = $this->service->formattingUsingSeparator($event['start']);
        $formatedEnd = $this->service->formattingUsingSeparator($event['end']);
        $this->start = $formatedStart;
        $this->end = $formatedEnd;
        $this->agreement = true;
        $this->roomId = $roomIds;
        $this->status = $event['status'];
        $this->showModal = true;
    }
    public function updateBooking()
    {
        $this->validate();
        $userId = auth()->user()->id;
        $formatedStart = $this->service->formattingUsingSeparator($this->start);
        $formatedEnd = $this->service->formattingUsingSeparator($this->end);
        $process = $this->bookingService->editBooking(
            $this->bookingId,
            $this->eventName,
            $this->eventDescription,
            $formatedStart,
            $formatedEnd,
            $userId,
            $this->roomId,
            $this->status
        );
        if ($process)
        {
            $this->showModal = false;
            return Notification::make()
                ->title('Booking Successfully Updated')
                ->body('Your booking has been successfully updated. Please check your account for the latest details. Thank you!')
                ->success()
                ->send();
        }
        $this->showModal = false;
        return Notification::make()
            ->title('Failed to Update Booking')
            ->body('We’re sorry, but we couldn’t update your booking at this time. Please try again later or contact our support team for assistance.')
            ->danger()
            ->send();
    }

    public function showModalConfirmDeletion($id)
    {
        $this->modalDeletion = !$this->modalDeletion;
        if ($this->modalDeletion)
        {
            return $this->bookIdSelected = $id;
        }
        return $this->bookIdSelected = null;
    }
    public function showModalConfirmCancel($id)
    {
        $this->modalCancel = !$this->modalCancel;
        if ($this->modalCancel)
        {
            return $this->bookIdSelected = $id;
        }
        return $this->bookIdSelected = null;
    }
    public function delete($id)
    {
        $process = $this->bookingService->deleteBooking($id);
        if ($process){
            $this->modalDeletion = !$this->modalDeletion;
            return Notification::make()
                ->title('Booking Successfully Deleted')
                ->body('Your booking has been successfully deleted. If you need further assistance, please contact our support team. Thank you!')
                ->success()
                ->send();
        }
        $this->modalDeletion = !$this->modalDeletion;
        return Notification::make()
            ->title('Booking Deletion Unsuccessful')
            ->body('We’re sorry, but we couldn’t delete your booking at this time. Please try again later or contact our support team for assistance.')
            ->danger()
            ->send();
    }

    public function cancelBooking($id)
    {
        $process = $this->bookingService->cancelBooking($id);
        if ($process){
            $this->modalCancel = !$this->modalCancel;
            return Notification::make()
                ->title('Booking Successfully Deleted')
                ->body('Your booking has been successfully deleted. If you need further assistance, please contact our support team. Thank you!')
                ->success()
                ->send();
        }
        $this->modalCancel = !$this->modalCancel;
        return Notification::make()
            ->title('Booking Deletion Unsuccessful')
            ->body('We’re sorry, but we couldn’t delete your booking at this time. Please try again later or contact our support team for assistance.')
            ->danger()
            ->send();
    }

    public function toggleModal(): void
    {
        $this->start = null;
        $this->end = null;
        $this->showModal = !$this->showModal;
    }

    public function render()
    {
        $listApplication = RequestRoom::where('user_id', $this->userId)
            ->with('rooms')
            ->paginate(10);

        return view('livewire.application-page', ['listApplication' => $listApplication]);
    }
}
