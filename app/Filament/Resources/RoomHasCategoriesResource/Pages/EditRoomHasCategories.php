<?php

namespace App\Filament\Resources\RoomHasCategoriesResource\Pages;

use App\Filament\Resources\RoomHasCategoriesResource;
use App\Models\Room;
use App\Models\RoomCategories;
use App\Models\RoomHasCategories;
use Filament\Actions;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\EditRecord;

class EditRoomHasCategories extends EditRecord
{
    protected static string $resource = RoomHasCategoriesResource::class;

    public array $selectedRooms = [];

    public function mount($record): void
    {
        parent::mount($record);

        // Preload selected room IDs from the pivot table
        $this->selectedRooms = RoomHasCategories::where('room_category_id', $record)
            ->pluck('room_id')
            ->toArray();
        $this->form->fill(['id' => $record,'rooms' => $this->selectedRooms]);

//        dd($this->selectedRooms);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Assign Categories')
                    ->schema([
                        Split::make([
                            Section::make([
                                Select::make('id')
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
                                    ->default($this->selectedRooms)
                                    ->required()
                                    ->columns(3)
                                    ->bulkToggleable()
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 3,
                                    ])
                            ])
                        ])
                            ->columnSpan('full')
                    ])
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
