<?php

namespace App\Filament\Resources\RequestRoomResource\Pages;

use App\Filament\Resources\RequestRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRequestRooms extends ListRecords
{
    protected static string $resource = RequestRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
