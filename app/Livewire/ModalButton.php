<?php

namespace App\Livewire;

use Livewire\Component;

class ModalButton extends Component
{
    public function toggleModal()
    {
        $this->dispatch('showModal')->to(RequestRoomModal::class);
    }

    public function render()
    {
        return view('livewire.modal-button');
    }
}
