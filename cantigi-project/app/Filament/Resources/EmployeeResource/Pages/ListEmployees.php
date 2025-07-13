<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Karyawan'),
            ExportAction::make()
                ->label("Export ke Excel")
                ->color('gray')
                ->exports([
                    ExcelExport::make()->withColumns([
                        Column::make('employee.user.name')
                            ->heading("Nama Karyawan")
                            ->getStateUsing(fn($record) => $record->user?->name ?? $record->name),
                        Column::make('employee.user.phone_number')
                            ->heading("Nomor HP")
                            ->getStateUsing(fn($record) => $record->user?->phone_number ?? "Belum tersedia"),
                        Column::make('employee.user.email')
                            ->heading('Email')
                            ->getStateUsing(fn($record) => $record->user?->email ?? 'Belum tersedia'),
                        Column::make('position')
                            ->heading('Jabatan'),
                        Column::make('status')
                            ->heading('Status'),
                    ])
                ]),
            
        ];
    }
}
