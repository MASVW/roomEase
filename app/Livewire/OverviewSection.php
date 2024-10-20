<?php

namespace App\Livewire;

use Livewire\Component;

class OverviewSection extends Component
{
    public $selectedRoom;
    public function render()
    {
        return view('livewire.overview-section');
    }
}
