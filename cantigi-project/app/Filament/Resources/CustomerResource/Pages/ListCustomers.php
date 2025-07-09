<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Imports\CustomerImporter;
use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Pelanggan Baru'),
            Actions\ImportAction::make()
                ->importer(CustomerImporter::class)
                ->label('Import dari Excel')
                ->csvDelimiter(';'),
        ];
    }
}
