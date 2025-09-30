<?php

namespace App\Filament\Resources\Cages\Schemas;

use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Schema;

class CageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('farmer_id')
                    ->relationship('farmer', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('location'),
                TextInput::make('capacity')
                    ->required()
                    ->numeric(),
            ]);
    }
}
