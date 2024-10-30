<?php

namespace App\Filament\Resources\RoomCategoriesResource\Pages;

use App\Filament\Resources\RoomCategoriesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRoomCategories extends EditRecord
{
    protected static string $resource = RoomCategoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
