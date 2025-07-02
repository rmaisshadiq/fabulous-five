<?php

namespace App\Filament\Resources\ReturnLogResource\Pages;

use App\Filament\Resources\ReturnLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReturnLogs extends ListRecords
{
    protected static string $resource = ReturnLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
