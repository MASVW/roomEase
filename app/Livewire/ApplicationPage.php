<?php

namespace App\Livewire;

use App\Models\RequestRoom;
use App\Models\Room;
use App\Service\FormattingDateService;
use Carbon\Carbon;
use Livewire\Component;

class ApplicationPage extends Component
{
    public $userId;
    public $listApplication;

    protected $service;
    public function __construct()
    {
        $this->service = app(FormattingDateService::class);
    }

    public function mount($id)
    {
        $this->userId = $id;
        $this->listApplication = RequestRoom::where('user_id', $this->userId)->with('room')->get();
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

    public function render()
    {
        return view('livewire.application-page');
    }
}
