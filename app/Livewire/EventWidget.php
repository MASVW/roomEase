<?php

namespace App\Livewire;

use App\Service\FormattingDateService;
use Livewire\Component;

class EventWidget extends Component
{
    public $listBooking;

    public function render()
    {
        return view('livewire.event-widget');
    }
}
