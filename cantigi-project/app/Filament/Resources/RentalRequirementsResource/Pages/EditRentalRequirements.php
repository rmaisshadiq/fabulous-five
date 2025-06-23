<?php

namespace App\Filament\Resources\RentalRequirementsResource\Pages;

use App\Filament\Resources\RentalRequirementsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRentalRequirements extends EditRecord
{
    protected static string $resource = RentalRequirementsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
