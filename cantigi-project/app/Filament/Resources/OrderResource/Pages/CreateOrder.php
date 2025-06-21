<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function afterCreate(): void
{
    $vehicle = $this->record->vehicle;

    if ($vehicle && $vehicle->status === 'active') {
        $vehicle->update(['status' => 'rented']);
    }

    Notification::make()
        ->title('Kendaraan diset menjadi "rented"')
        ->success()
        ->send();
}
}
