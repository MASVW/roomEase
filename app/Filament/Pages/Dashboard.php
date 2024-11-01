<?php

namespace App\Filament\Pages;

use App\Models\Calendar;
use App\Models\RequestRoom;
use App\Service\BookingService;
use App\Service\CalendarService;
use App\Service\FormattingDateService;
use Illuminate\Support\Collection;

class Dashboard extends \Filament\Pages\Dashboard
{
    public $data = [];
    public $listBooking;
    public $formattingDate;

    protected $service;





    protected static string $view = 'calendar.calendar';

    public function __construct()
    {
        $this->service = new \stdClass();
        $this->service->booking = app(BookingService::class);
        $this->service->date = app(FormattingDateService::class);
        $this->service->calendar = app(CalendarService::class);
    }

    public function mount(): void
    {
        $this->data = $this->service->calendar->refreshDataCalendarHasApproved();
        $this->listBooking = $this->formattingToStringWithDuration($this->service->booking->listBooking());
//        dd($this->listBooking);
    }


    public function formattingToStringWithDuration($data)
    {
        $afterFormatting = [];
        foreach($data as $data){
            $data['duration'] = $this->service->date->formattingToStringWithDuration($data['start'], $data['end']);
            $afterFormatting[] = $data;
        }
        return $afterFormatting;
    }
}
