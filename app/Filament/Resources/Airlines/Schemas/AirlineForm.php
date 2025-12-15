<?php

namespace App\Filament\Resources\Airlines\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;

class AirlineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('logo')
                    ->image()
                    ->directory('airlines')
                    ->columnSpan(2)
                ->required()
                ->disk('public'),
                TextInput::make('code')
                    ->required(),
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
