<?php

namespace App\Filament\Resources\RoomCategoriesResource\Pages;

use App\Filament\Resources\RoomCategoriesResource;
use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;

class EditRoomCategories extends EditRecord
{
    protected static string $resource = RoomCategoriesResource::class;

    public function form(Form $form): Form
    {
        $existingTypes = DB::table('room_categories')
            ->select('type')
            ->distinct()
            ->pluck('type')
            ->toArray();

        $predefinedTypes = [
            'building' => 'Building Location',
            'floor' => 'Floor Level',
            'connection' => 'Connection Type',
            'style' => 'Room Style',
        ];

        $customTypes = array_diff($existingTypes, array_keys($predefinedTypes));
        $allTypes = array_merge(
            $predefinedTypes,
            array_combine($customTypes, $customTypes)
        );

        return $form
            ->schema([
                Section::make('Category Details')
                    ->schema([
                        Select::make('type')
                            ->label('Category Type')
                            ->options($allTypes)
                            ->searchable()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('New Type Name')
                            ])
                            ->createOptionUsing(function ($data) {
                                return $data['name'];
                            })
                            ->reactive(),

                        Select::make('name')
                            ->label('Category Name')
                            ->options(function (callable $get) {
                                if (!in_array($get('type'), ['building', 'floor', 'connection', 'style'])) {
                                    $existingNames = DB::table('room_categories')
                                        ->where('type', $get('type'))
                                        ->pluck('name', 'name')
                                        ->toArray();
                                    return $existingNames;
                                }

                                return match ($get('type')) {
                                    'building' => [
                                        'AD' => 'Aryaduta (AD)',
                                        'LP' => 'Lippo Plaza (LP)',
                                    ],
                                    'floor' => [
                                        '5' => '5th Floor',
                                        '6' => '6th Floor',
                                        '7' => '7th Floor',
                                    ],
                                    'connection' => [
                                        '2rooms' => '2 Rooms Connection',
                                        '3rooms' => '3 Rooms Connection',
                                        '4rooms' => '4 Rooms Connection',
                                    ],
                                    'style' => [
                                        'harvard' => 'Harvard Style',
                                        'computer_lab' => 'Computer Laboratory',
                                        'round_table' => 'Round Table',
                                    ],
                                    default => [],
                                };
                            })
                            ->searchable()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('New Name')
                            ])
                            ->createOptionUsing(function ($data) {
                                return $data['name'];
                            }),
                    ])
                    ->columns(2),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
