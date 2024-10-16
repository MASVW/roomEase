<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Models\RequestRoom;
use App\Models\Room;
use Carbon\Carbon;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'gmdi-room-preferences-o';

    protected static ?string $activeNavigationIcon = 'gmdi-room-preferences-r';

    protected static ?int $navigationSort = 1;

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
                Tables\Columns\ImageColumn::make('img')
                    ->label('Image'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Room Name'),
                Tables\Columns\TextColumn::make('location')
                    ->label('Location'),
                Tables\Columns\TextColumn::make('id')
                ->label('Status')
                    ->formatStateUsing(function($state){
                        $nextBooking = RequestRoom::where('room_id', $state)
                            ->where('status', 'approved')
                            ->where('end_time', '>', Carbon::now())
                            ->orderBy('end_time', 'asc')
                            ->first();

                        if ($nextBooking) {
                            return "Booked At " . $nextBooking->end_time->format('d M');
                        }

                        return "Available";
                    })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hiddenLabel(),
                Tables\Actions\DeleteAction::make()
                    ->hiddenLabel(),
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
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
