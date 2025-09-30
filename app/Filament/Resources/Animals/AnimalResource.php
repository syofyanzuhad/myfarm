<?php

namespace App\Filament\Resources\Animals;

use App\Filament\Resources\Animals\Pages\CreateAnimal;
use App\Filament\Resources\Animals\Pages\EditAnimal;
use App\Filament\Resources\Animals\Pages\ListAnimals;
use App\Filament\Resources\Animals\Schemas\AnimalForm;
use App\Filament\Resources\Animals\Tables\AnimalsTable;
use App\Models\Animal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AnimalResource extends Resource
{
    protected static ?string $model = Animal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Ternak';

    protected static ?string $modelLabel = 'Ternak';

    protected static ?string $pluralModelLabel = 'Ternak';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasAnyRole(['admin', 'peternak', 'petugas']);
    }

    public static function form(Schema $schema): Schema
    {
        return AnimalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AnimalsTable::configure($table);
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
            'index' => ListAnimals::route('/'),
            'create' => CreateAnimal::route('/create'),
            'edit' => EditAnimal::route('/{record}/edit'),
        ];
    }
}
