<?php

namespace App\Filament\Resources\FinancialReportResource\Pages;

use App\Filament\Resources\FinancialReportResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFinancialReports extends ListRecords
{
    protected static string $resource = FinancialReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Laporan Baru'),
            Actions\Action::make('download_report')
                ->label('Download Report')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function() {
                    $reports = $this->getFilteredTableQuery()->with('vehicle')->get();
                    $pdf = Pdf::loadView('pdf.financial-report', ['reports' => $reports]);
                    return response()->streamDownload(
                        fn() => print($pdf->output()),
                        "financial-report-" . now()->format('Y-m-d') . ".pdf"
                    );
                })
        ];
    }
}
