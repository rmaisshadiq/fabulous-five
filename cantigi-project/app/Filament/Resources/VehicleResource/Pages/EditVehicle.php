<?php

namespace App\Filament\Resources\VehicleResource\Pages;

use App\Filament\Resources\VehicleResource;
use App\Models\Maintenance;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;


class EditVehicle extends EditRecord
{
    protected static string $resource = VehicleResource::class;

    protected function getHeaderActions(): array
{
   

    return [
        Actions\DeleteAction::make(),

    ];
}


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
