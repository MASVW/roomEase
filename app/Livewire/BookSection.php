<?php

namespace App\Livewire;

use Livewire\Component;

class BookSection extends Component
{
    public $selectedRoom;

    public function render()
    {
        return view('livewire.book-section');
    }
}
