<?php

namespace App\Filament\Resources\Flights\Pages;

use App\Models\Flight;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Flights\FlightResource;

class CreateFlight extends CreateRecord
{
    protected static string $resource = FlightResource::class;

    protected function afterCreate(): void
    {
        $flight = Flight::find($this->record->id);

        $flight->generateSeats();
    }
}
