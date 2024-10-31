<?php

namespace App\Livewire;

use App\Models\Room;
use Livewire\Component;

class ViewRoomPage extends Component
{
    public $categoryName;

    public function mount($categoryName)
    {
        $this->category = $categoryName;
    }

    public function render()
    {
        $rooms = Room::whereHas('roomCategories', function($query) {
            $query->where('name', $this->category);
        })->with('roomCategories')->get();

        return view('livewire.view-room-page', ['rooms' => $rooms]);
    }
}
