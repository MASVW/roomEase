<?php

namespace App\Filament\Resources\CalendarResource\Pages;

use App\Filament\Resources\CalendarResource;
use App\Models\Calendar;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Collection;

class ListCalendars extends ListRecords
{
    public $data = [];

    protected static string $resource = CalendarResource::class;

    protected static string $view = "calendar.calendar";

    public function mount(): void
    {
        $initData = $this->initData();
        $this->storeData($initData);
    }

    public function initData(): Collection
    {
        return Calendar::all();
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


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
