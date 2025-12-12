<?php

namespace App\Filament\Resources\Flights\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;

class FlightForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Flight Information')
                        ->schema([
                            TextInput::make('flight_number')
                                ->unique(ignoreRecord: true)
                                ->required(),
                            Select::make('airline_id')
                                ->relationship('airline', 'name')
                                ->required()
                        ]),
                    Step::make('Flight Segments')
                        ->schema([
                            Repeater::make('flight_segments')
                                ->relationship('flightSegments')
                                ->schema([
                                    TextInput::make('sequence')
                                        ->required(),
                                    Select::make('airport_id')
                                        ->relationship('airport', 'name')
                                        ->required(),
                                    DateTimePicker::make('time')
                                        ->required()
                                ])
                                ->collapsed(false)
                                ->minItems(1)
                        ]),
                    Step::make('Flight Class')
                        ->schema([
                            Repeater::make('flight_classes')
                                ->relationship('flightClasses')
                                ->schema([
                                    Select::make('class_type')
                                        ->options([
                                            'economy' => 'Economy',
                                            'bussiness' => 'Bussiness',
                                        ])
                                        ->required(),
                                    TextInput::make('price')
                                        ->numeric()
                                        ->prefix('IDR')
                                        ->minValue(0)
                                        ->required(),
                                    TextInput::make('total_seats')
                                        ->numeric()
                                        ->minValue(1)
                                        ->label('Total Seats')
                                        ->required(),
                                    Select::make('facilities')
                                        ->relationship('facilities', 'name')
                                        ->multiple()
                                        ->required()
                                ])
                                ->columns(2)
                        ]),
                ])->columnSpan(2)
            ]);
    }
}
