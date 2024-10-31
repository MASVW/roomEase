<?php

namespace App\Filament\Resources\RoomResource\Pages;

use App\Filament\Resources\RoomResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditRoom extends EditRecord
{
    protected static string $resource = RoomResource::class;
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Room Information')
                    ->description('Basic information about the room')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Room Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter room name')
                                    ->unique(ignoreRecord: true), // Unique validation

                                Select::make('location')
                                    ->label('Location')
                                    ->options([
                                        'LP' => 'LP',
                                        'AD' => 'AD',
                                    ])
                                    ->required()
                                    ->native(false), // Custom dropdown style

                                TextInput::make('capacity')
                                    ->label('Capacity')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->maxValue(1000)
                                    ->suffix('People')
                                    ->placeholder('Enter room capacity'),

                                Select::make('room_categories')
                                    ->relationship('roomCategories', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->required()
                            ]),
                    ]),

                Section::make('Additional Details')
                    ->schema([
                        RichEditor::make('facilities')
                            ->label('Facilities')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                            ])
                            ->placeholder('List the facilities available in this room')
                            ->columnSpanFull(),

                        FileUpload::make('img')
                            ->label('Room Image')
                            ->image()
                            ->multiple()
                            ->imageEditor()
                            ->directory(function ($record) {
                                return 'room-images/' . ($record ? $record->name : 'temp');
                            })
                            ->getUploadedFileNameForStorageUsing(
                                function (FileUpload $component, TemporaryUploadedFile $file, $record) {
                                    $roomName = $record ? $record->name : 'temp';
                                    $timestamp = Carbon::now()->format('Ymd-His');
                                    $uniqueId = uniqid();
                                    return $roomName . '-' . $uniqueId . '-' . $timestamp . '.' . $file->getClientOriginalExtension();
                                }
                            )
                            ->afterStateUpdated(function ($state, $record) {
                                if (!$record) return;

                                if ($state && is_array($state)) {
                                    foreach ($state as $key => $file) {
                                        if (Str::contains($file, 'temp/')) {
                                            $newPath = str_replace('temp', $record->name, $file);
                                            Storage::move($file, $newPath);
                                            $state[$key] = $newPath;
                                        }
                                    }
                                }
                            })
                            ->preserveFilenames(false)
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/png', 'image/jpeg'])
                            ->helperText('Upload an image of the room (max 2MB)')
                            ->imagePreviewHeight('250')
                            ->loadingIndicatorPosition('left')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadProgressIndicatorPosition('left')
                            ->columnSpanFull()
                    ]),
            ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
