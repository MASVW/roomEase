<?php

namespace App\Livewire;

use App\Models\Calendar;
use App\Models\Room;
use Illuminate\Support\Collection;
use Livewire\Component;

class HomePage extends Component
{
    public $data = [];

    public $room;
    //TODO: Creating Title For Page
    public $title;

    public function mount(): void
    {
        $this->room = $this->initDataRoom();
        $initData = $this->initDataCalendar();
        $this->storeData($initData);
    }
    public function initDataCalendar(): Collection
    {
        return Calendar::all();
    }

    public function initDataRoom(): Collection
    {
        return Room::limit(12)->get();
    }
    public function storeData($data): void
    {
        foreach($data as $item)
        {
            $this->data[] = [
                'title' => $item->event_title,
                'start' => $item->start,
                'end' => $item->end,
            ];
        }
    }
    public function render()
    {
        return view('livewire.home-component');
    }
}
