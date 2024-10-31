<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\Tables\Actions\GenerateQrAction;
use App\Models\RequestRoom;
use App\Models\Room;
use App\Service\QRService;
use App\Tables\Columns\QRGenerator;
use Carbon\Carbon;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'gmdi-room-preferences-o';

    protected static ?string $activeNavigationIcon = 'gmdi-room-preferences-r';

    protected static ?string $navigationGroup = 'Room Management';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Room';
    protected static ?string $pluralModelLabel = 'Room';


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
                    ->label('Room Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Location')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('id')
                ->label('Status')
                    ->formatStateUsing(function($state){
                        $nextBooking = RequestRoom::whereHas('rooms', function($query) use ($state) {
                            $query->where('rooms.id', $state);  // Assuming 'rooms' is the relationship name in RequestRoom model
                        })
                            ->where('status', 'approved')
                            ->where('end', '>', Carbon::now())
                            ->orderBy('end', 'asc')
                            ->first();

                        if ($nextBooking) {
                            $endDate = Carbon::parse($nextBooking->end);
                            return "Booked At " . $endDate->format('d M');
                        }

                        return "Available";
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('generateQr')
                    ->hiddenLabel()
                    ->icon('heroicon-o-qr-code')
                    ->url(fn($record) => route('rooms.downloadQr', ['id' => $record->id]))
                    ->openUrlInNewTab(false),
                Tables\Actions\EditAction::make()
                    ->hiddenLabel(),
                Tables\Actions\DeleteAction::make()
                    ->hiddenLabel(),
            ])
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public function text()
    {
        return redirect("/");
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
