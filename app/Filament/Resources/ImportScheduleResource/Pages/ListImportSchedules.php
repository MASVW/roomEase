<?php

namespace App\Filament\Resources\ImportScheduleResource\Pages;

use App\Filament\Resources\ImportScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListImportSchedules extends ListRecords
{
    protected static string $resource = ImportScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
