<?php

namespace App\Livewire;

use Livewire\Component;

class DocumentationComponent extends Component
{
    public $room;
    public $data;

    public function mount($room)
    {
        $this->room = $room;
    }
    public function render()
    {
        return view('livewire.documentation-component');
    }
}
