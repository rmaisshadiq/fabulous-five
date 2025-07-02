<?php

namespace App\Filament\Resources\ReturnLogResource\Pages;

use App\Filament\Resources\ReturnLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReturnLog extends EditRecord
{
    protected static string $resource = ReturnLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
