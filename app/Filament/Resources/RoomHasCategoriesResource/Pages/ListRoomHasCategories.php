<?php

namespace App\Filament\Resources\RoomHasCategoriesResource\Pages;

use App\Filament\Resources\RoomHasCategoriesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoomHasCategories extends ListRecords
{
    protected static string $resource = RoomHasCategoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
