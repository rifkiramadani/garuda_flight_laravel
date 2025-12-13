<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Repeater;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->schema([
                        TextInput::make('code'),
                        Select::make('flight_id')
                            ->relationship('flight', 'flight_number'),
                        Select::make('flight_class_id')
                            ->relationship('flightClass', 'class_type'),
                    ])->columnSpan(2),
                Section::make('Passangers Information')
                    ->schema([
                        TextInput::make('number_of_passangers'),
                        TextInput::make('name'),
                        TextInput::make('email'),
                        TextInput::make('phone'),
                        Section::make('List Of Passangers')
                            ->schema([
                                Repeater::make('transaction_passengers')
                                    ->relationship('transactionPassengers')
                                    ->schema([
                                        TextInput::make('flightSeat.name'),
                                        TextInput::make('name'),
                                        TextInput::make('date_of_birth'),
                                        TextInput::make('nationality')
                                    ])
                                    ->columns(2),
                            ])
                    ])->columnSpan(2),
                Section::make('Payment')
                    ->schema([
                        TextInput::make('promoCode.code'),
                        TextInput::make('promoCode.discount_type'),
                        TextInput::make('promoCode.discount'),
                        TextInput::make('payment_status'),
                        TextInput::make('subtotal'),
                        TextInput::make('grandtotal'),
                    ])
            ]);
    }
}
