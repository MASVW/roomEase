<?php

namespace App\Livewire;

use App\Models\Room;
use Livewire\Component;

class ApplicationPage extends Component
{
    public $userId;
    public function mount($id)
    {
        $this->userId = $id;
    }
    public function render()
    {
        return view('livewire.application-page');
    }
}
