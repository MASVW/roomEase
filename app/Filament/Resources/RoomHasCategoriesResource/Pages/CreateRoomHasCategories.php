<?php

namespace App\Filament\Resources\RoomHasCategoriesResource\Pages;

use App\Filament\Resources\RoomHasCategoriesResource;
use App\Models\Room;
use App\Models\RoomCategories;
use Filament\Actions;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateRoomHasCategories extends CreateRecord
{
    protected static string $resource = RoomHasCategoriesResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Assign Categories')
                    ->schema([
                        Split::make([
                            Section::make([
                                Select::make('category')
                                    ->label('Category')
                                    ->options(RoomCategories::pluck('name', 'id'))
                                    ->required()
                                    ->live(),
                            ])->grow(false),

                            Section::make([
                                CheckboxList::make('rooms')
                                    ->label('Select Rooms')
                                    ->options(function (Get $get) {
                                        $categoryId = $get('category');

                                        $query = Room::query();

                                        if ($categoryId) {
                                            $query->whereDoesntHave('roomCategories', function ($q) use ($categoryId) {
                                                $q->where('room_categories.id', $categoryId);
                                            });
                                        }

                                        return $query->pluck('name', 'id');
                                    })
                                    ->required()
                                    ->columns(3)
                                    ->bulkToggleable()
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 3,
                                    ]),
                            ])
                        ])
                            ->columnSpan('full')
                    ])
            ]);
    }

    protected function handleRecordCreation(array $data): Model
    {
        $category = RoomCategories::findOrFail($data['category']);
        $category->rooms()->syncWithoutDetaching($data['rooms']);
        return $category;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
