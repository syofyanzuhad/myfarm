<?php

namespace App\Filament\Resources\HealthRecords\Pages;

use App\Filament\Resources\HealthRecords\HealthRecordResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHealthRecord extends EditRecord
{
    protected static string $resource = HealthRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
