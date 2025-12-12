<?php

namespace App\Filament\Resources\Flights\Tables;

use App\Models\Flight;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class FlightsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('flight_number'),
                TextColumn::make('airline.name'),
                // TextColumn::make('flight_segments')
                //     ->label('Route & Duration')
                //     ->formatStateUsing(function (Flight $record): string {
                //         $firstSegment = $record->flightSegments->first();
                //         $lastSegment = $record->flightSegments->last();
                //         $route = $firstSegment->airport->iata_code . ' - ' . $lastSegment->airport->iata_code;
                //         $duration = (new \DateTime($firstSegment->time))->format('d F Y H:i') . ' - ' . (new \DateTime($lastSegment->time))->format('d F Y H:i');
                //         return $route . ' | ' . $duration;
                //     })
                TextColumn::make('flight_segment')
                    ->label('Route & Duration')
                    // Menggunakan getStateUsing untuk logika relasi yang kompleks
                    ->getStateUsing(function (Flight $record): string {
                        // Pastikan relasi 'flightSegments' dimuat
                        if ($record->flightSegments->isEmpty()) {
                            return '— Data Segmen Tidak Tersedia —';
                        }

                        // Urutkan berdasarkan sequence untuk mendapatkan awal dan akhir yang benar
                        $segments = $record->flightSegments->sortBy('sequence');

                        $firstSegment = $segments->first();
                        $lastSegment = $segments->last();

                        // Menggunakan operator Nullsafe (?->) dan Null Coalescing (??)
                        // untuk mencegah error jika relasi 'airport' belum dimuat atau null.
                        $startIata = $firstSegment->airport?->iata_code ?? '???';
                        $endIata = $lastSegment->airport?->iata_code ?? '???';

                        $route = $startIata . ' - ' . $endIata;

                        // Pengecekan waktu
                        $startTime = $firstSegment->time
                            ? (new \DateTime($firstSegment->time))->format('d F Y H:i')
                            : 'Waktu Awal Tidak Ada';
                        $endTime = $lastSegment->time
                            ? (new \DateTime($lastSegment->time))->format('d F Y H:i')
                            : 'Waktu Akhir Tidak Ada';

                        $duration = $startTime . ' - ' . $endTime;

                        return $route . ' | ' . $duration;
                    })
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
