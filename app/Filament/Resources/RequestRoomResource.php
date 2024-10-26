<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestRoomResource\Pages;
use App\Filament\Resources\RequestRoomResource\RelationManagers;
use App\Models\RequestRoom;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequestRoomResource extends Resource
{
    protected static ?string $model = RequestRoom::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $activeNavigationIcon = 'heroicon-s-document';

    protected static ?int $navigationSort = 4;

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
                Tables\Columns\TextColumn::make('title')
                    ->weight(FontWeight::Bold)
                    ->label('Event Name')
                    ->description(fn(RequestRoom $record):string => $record->description),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Username')
                    ->badge()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        "pending" => 'gray',
                        "approved" => 'success',
                        "rejected" => 'danger'
                    })
                    ->label('Status')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end')
                    ->label('Event Scheduled')
                    ->formatStateUsing(function ($record) {
                        // Parsing tanggal awal dan akhir
                        $start = Carbon::parse($record->start)->startOfDay();
                        $end = Carbon::parse($record->end)->endOfDay();

                        if ($start->isSameDay($end)) {
                            $hours = Carbon::parse($record->start)->diffInHours($record->end);
                            $duration = "($hours Hours)";
                        } else {
                            $startTime = Carbon::parse($record->start);
                            $endTime = Carbon::parse($record->end);
                            $days = $startTime->diffInDays($endTime) + 1;
                            $formatted = number_format($days, 0);
                            $duration = "({$formatted} Days)";
                        }

                        // Tampilkan tanggal mulai dan durasi
                        return  $start->format('d M Y') . ' ' . $duration;
                    })
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->hiddenLabel()
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
            'index' => Pages\ListRequestRooms::route('/'),
            'create' => Pages\CreateRequestRoom::route('/create'),
            'edit' => Pages\EditRequestRoom::route('/{record}/edit'),
        ];
    }
}
