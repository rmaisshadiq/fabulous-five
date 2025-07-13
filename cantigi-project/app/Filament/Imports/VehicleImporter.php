<?php

namespace App\Filament\Imports;

use App\Models\Vehicle;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class VehicleImporter extends Importer
{
    protected static ?string $model = Vehicle::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('brand')
                ->label('Merk Kendaraan')
                ->rules(['max:255']),
            ImportColumn::make('model')
                ->label('Model Kendaraan')
                ->rules(['max:255']),
            ImportColumn::make('car_type')
                ->label('Tipe Kendaraan')
                ->rules(['max:255']),
            ImportColumn::make('license_plate')
                ->label('Plat Kendaraan')
                ->rules(['max:255']),
            ImportColumn::make('price_per_day')
                ->label('Harga per hari')
                ->rules(['max:255']),
            ImportColumn::make('status')
                ->label('Status Kendaraan')
                ->rules(['max:255']),
            
        ];
    }

    public function resolveRecord(): ?Vehicle
    {
        // return Vehicle::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Vehicle();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your vehicle import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
