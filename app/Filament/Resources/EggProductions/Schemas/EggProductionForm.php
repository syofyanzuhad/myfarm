<?php

namespace App\Filament\Resources\EggProductions\Schemas;

use Filament\Schemas\Components\DatePicker;
use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\Textarea;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Schema;

class EggProductionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('animal_id')
                    ->label('Ternak')
                    ->relationship('animal', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->farmer->name} - {$record->type} ({$record->quantity} ekor)")
                    ->searchable()
                    ->preload()
                    ->required(),
                DatePicker::make('date')
                    ->label('Tanggal')
                    ->required()
                    ->native(false)
                    ->maxDate(now()),
                TextInput::make('quantity')
                    ->label('Jumlah Telur')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->suffix('butir'),
                Textarea::make('notes')
                    ->label('Catatan')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
