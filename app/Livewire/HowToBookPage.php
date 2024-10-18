<?php

namespace App\Livewire;

use App\Models\Calendar;
use App\Models\Room;
use Illuminate\Support\Collection;
use Livewire\Component;

class HowToBookPage extends Component
{
    public $data = [];
    public $room;

    public function mount(): void
    {
        $initData = $this->initDataCalendar();
        $this->room = $this->initDataRoom();
        $this->storeData($initData);
    }
    public function initDataCalendar(): Collection
    {
        return Calendar::all();
    }

    public function initDataRoom(): Collection
    {
        return Room::limit(5)->get();
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
        return view('livewire.how-to-book-page');
    }
}
