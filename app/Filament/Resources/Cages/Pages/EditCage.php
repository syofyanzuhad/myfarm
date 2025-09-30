<?php

namespace App\Filament\Resources\Cages\Pages;

use App\Filament\Resources\Cages\CageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCage extends EditRecord
{
    protected static string $resource = CageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
