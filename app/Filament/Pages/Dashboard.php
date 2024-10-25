<?php

namespace App\Filament\Pages;

use App\Models\Calendar;
use App\Models\RequestRoom;
use Illuminate\Support\Collection;

class Dashboard extends \Filament\Pages\Dashboard
{
    public $data = [];

    protected static string $view = 'calendar.calendar';

    public function mount(): void
    {
        $initData = $this->initData();
        $this->storeData($initData);
    }

    public function initData(): Collection
    {
        /**
         * TODO: Calendar is the model to store all approved booking
         **/
        return RequestRoom::all();
    }

    public function storeData($data): void
    {
        foreach($data as $item)
        {
            $this->data[] = [
                'title' => $item->title,
                'start' => $item->start,
                'end' => $item->end,
            ];
        }
    }
}
