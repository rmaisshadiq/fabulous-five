<?php

namespace App\Filament\Resources\VehicleResource\Pages;

use App\Filament\Imports\VehicleImporter;
use App\Filament\Resources\VehicleResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListVehicles extends ListRecords
{
    protected static string $resource = VehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Kendaraan'),
            ExportAction::make()
                ->label("Export ke Excel")
                ->color('gray')
                ->exports([
                    ExcelExport::make()->withColumns([
                        Column::make('brand')
                            ->heading("Merk Kendaraan")
                            ->getStateUsing(fn($record) => $record->brand . ' ' . $record->model),
                        Column::make('license_plate')
                            ->heading('Plat Kendaraan'),
                        Column::make('price_per_day')
                            ->heading('Harga per hari')
                            ->getStateUsing(fn($record) => 'Rp ' . number_format($record->price_per_day, 0, ',', '.')),
                        Column::make('status')
                            ->heading('Status')
                    ])
                ]),
            ImportAction::make()
                ->importer(VehicleImporter::class)
                ->label('Import dari Excel')
                ->csvDelimiter(';')
                ->color('info')
        ];
    }
}
