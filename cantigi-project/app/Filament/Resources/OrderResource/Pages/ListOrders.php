<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exports([
                    ExcelExport::make('table')->fromTable()
                ]),


            Actions\Action::make('download_report')
                ->label('Download Report')
                ->action(function () {
                    $query = $this->getFilteredTableQuery();
                    $orders = $query->with('customer', 'vehicle')->get(); // Eager load relationships

                    // Point to the new view file
                    $pdf = Pdf::loadView('pdf.order-report', ['orders' => $orders]);

                    return response()->streamDownload(
                        fn() => print($pdf->output()),
                        "order-report-" . now()->format('Y-m-d') . ".pdf"
                    );
                }),
        ];
    }
}
