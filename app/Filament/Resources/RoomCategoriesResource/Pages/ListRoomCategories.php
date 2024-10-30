<?php

namespace App\Filament\Resources\RoomCategoriesResource\Pages;

use App\Filament\Resources\RoomCategoriesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoomCategories extends ListRecords
{
    protected static string $resource = RoomCategoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
