<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Imports\CustomerImporter;
use App\Filament\Resources\CustomerResource;
use App\Models\Customer;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Pelanggan Baru'),
            ExportAction::make()
                ->label("Export ke Excel")
                ->exports([
                    ExcelExport::make()->withColumns([
                        Column::make('user.name')
                            ->heading("Nama Pelanggan")
                            ->getStateUsing(fn($record) => $record->user?->name ?? $record->name),
                        Column::make('phone_number')
                            ->heading("Nomor HP")
                            ->getStateUsing(fn($record) => $record->phone_number ?? "Belum tersedia"),
                    ])
                ]),
            Actions\ImportAction::make()
                ->importer(CustomerImporter::class)
                ->label('Import dari Excel')
                ->csvDelimiter(';'),
        ];
    }
}
