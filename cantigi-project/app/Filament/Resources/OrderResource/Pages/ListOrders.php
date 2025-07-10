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
            Actions\CreateAction::make()
                ->label('Buat Laporan Baru'),


            Actions\Action::make('download_report')
                ->label('Download Report')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    // 1. Check if any vehicle filter (brand, model, or plate) is active.
                    $brandValue = data_get($this->tableFilters, 'vehicle.brand');
                    $modelValue = data_get($this->tableFilters, 'vehicle.model');
                    $plateValue = data_get($this->tableFilters, 'vehicle.license_plate');

                    $isVehicleFiltered = !empty($brandValue) || !empty($modelValue) || !empty($plateValue);

                    // 2. Check if any date filter (month or year) is active.
                    $monthValue = data_get($this->tableFilters, 'start_booking_date.value');
                    $yearValue = data_get($this->tableFilters, 'year.value');

                    $isDateFiltered = !empty($monthValue) || !empty($yearValue);

                    // 3. Set the view and filename based on the condition that BOTH a vehicle AND a date filter are active.
                    if ($isVehicleFiltered && $isDateFiltered) {
                        // This block runs ONLY if both a vehicle part AND a date part are filtered.
                        $viewName = 'pdf.filtered-order-report';
                        $filename = "filtered-order-report-" . now()->format('Y-m-d') . ".pdf";
                    } else {
                        // This block runs if only one category (vehicle or date), or neither, is used.
                        $viewName = 'pdf.order-report';
                        $filename = "all-orders-report-" . now()->format('Y-m-d') . ".pdf";
                    }

                    // 4. Get the data (this query still correctly applies any active filters).
                    $orders = $this->getFilteredTableQuery()->with('customer', 'vehicle')->get();

                    // 5. Load the dynamically selected view.
                    $pdf = Pdf::loadView($viewName, ['orders' => $orders]);

                    // 6. Return the download response.
                    return response()->streamDownload(
                        fn() => print($pdf->output()),
                        $filename
                    );
                }),
        ];
    }
}
