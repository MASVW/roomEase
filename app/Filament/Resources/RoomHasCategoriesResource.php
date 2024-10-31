<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomHasCategoriesResource\Pages;
use App\Filament\Resources\RoomHasCategoriesResource\RelationManagers;
use App\Models\RoomCategories;
use App\Models\RoomHasCategories;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomHasCategoriesResource extends Resource
{
    protected static ?string $model = RoomCategories::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Room Management';
    protected static ?string $navigationLabel = 'Category Assignment';
    protected static ?string $modelLabel = 'Category Assignment';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
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
                Tables\Columns\TextColumn::make('type')
                    ->label('Category Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rooms_count')
                    ->counts('rooms')
                    ->label('Assigned Rooms')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('rooms.name')
                    ->listWithLineBreaks()
                    ->limitList(3)
                    ->expandableLimitedList()
                    ->label('Room List'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit Room Assignment'),
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
            'index' => Pages\ListRoomHasCategories::route('/'),
            'create' => Pages\CreateRoomHasCategories::route('/create'),
            'edit' => Pages\EditRoomHasCategories::route('/{record}/edit'),
        ];
    }
}
