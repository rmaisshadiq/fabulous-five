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
    \Log::info('EditVehicle Record:', ['record' => $this->record?->toArray()]);

    return [
        Actions\DeleteAction::make(),

        Actions\Action::make('Selesaikan Maintenance')
            ->label('Selesaikan Maintenance')
            ->color('success')
            ->icon('heroicon-o-wrench')
            ->visible(function () {
                    $vehicle = $this->record;
                    return \App\Models\Maintenance::where('vehicle_id', $vehicle->id)->exists();
                })
            ->action(function () {
                $vehicle = $this->record;

                \Log::info('Tombol diklik untuk kendaraan:', ['id' => $vehicle->id]);

                $vehicle->status = 'active';
                $vehicle->last_maintenance_date = now();
                $vehicle->save();

                \App\Models\Maintenance::where('vehicle_id', $vehicle->id)->delete();

                \Filament\Notifications\Notification::make()
                    ->title('Maintenance diselesaikan')
                    ->success()
                    ->body("Kendaraan {$vehicle->model} kembali aktif.")
                    ->send();
            }),
    ];
}


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
