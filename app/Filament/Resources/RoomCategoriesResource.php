<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomCategoriesResource\Pages;
use App\Filament\Resources\RoomCategoriesResource\RelationManagers;
use App\Models\RoomCategories;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomCategoriesResource extends Resource
{
    protected static ?string $model = RoomCategories::class;

    protected static ?string $navigationIcon = 'tabler-category-2';
    protected static ?string $activeNavigationIcon = 'tabler-category-filled';
    protected static ?string $navigationGroup = 'Room Management';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Room Category';
    protected static ?string $pluralModelLabel = 'Room Categories';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Category Type')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'building' => 'Building Location',
                        'floor' => 'Floor Level',
                        'connection' => 'Connection Type',
                        'style' => 'Room Style',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Category Name')
                    ->formatStateUsing(function (string $state, $record): string {
                        return match ($record->type) {
                            'building' => $state === 'AD' ? 'Aryaduta (AD)' : 'Lippo Plaza (LP)',
                            'floor' => $state . 'th Floor',
                            'connection' => str_replace('rooms', ' Rooms Connection', $state),
                            'style' => match ($state) {
                                'harvard' => 'Harvard Style',
                                'computer_lab' => 'Computer Laboratory',
                                'round_table' => 'Round Table',
                                default => $state,
                            },
                            default => $state,
                        };
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'building' => 'Building Location',
                        'floor' => 'Floor Level',
                        'connection' => 'Connection Type',
                        'style' => 'Room Style',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoomCategories::route('/'),
            'create' => Pages\CreateRoomCategories::route('/create'),
            'edit' => Pages\EditRoomCategories::route('/{record}/edit'),
        ];
    }
}
