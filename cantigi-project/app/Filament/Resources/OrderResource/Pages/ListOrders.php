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
                    // 1. Check for the specific filters using data_get to safely access nested values.
                    $vehicleFilterValue = data_get($this->tableFilters, 'vehicle.brand.value');
                    $dateFilterValue = data_get($this->tableFilters, 'start_booking_date.value');

                    // A filter is considered active if its value is not empty (i.e., not null and not an empty string).
                    $isVehicleFiltered = !empty($vehicleFilterValue);
                    $isDateFiltered = !empty($dateFilterValue);

                    // 2. Set the view and filename based on the condition that BOTH filters are active.
                    if ($isVehicleFiltered && $isDateFiltered) {
                        // This block runs ONLY if both vehicle AND date are filtered.
                        $viewName = 'pdf.filtered-order-report';
                        $filename = "filtered-order-report-" . now()->format('Y-m-d') . ".pdf";
                    } else {
                        // This block runs if only one, or none, of the filters are used.
                        $viewName = 'pdf.order-report';
                        $filename = "all-orders-report-" . now()->format('Y-m-d') . ".pdf";
                    }

                    // 3. Get the data (this query still correctly applies any active filters).
                    $orders = $this->getFilteredTableQuery()->with('customer', 'vehicle')->get();

                    // 4. Load the dynamically selected view.
                    $pdf = Pdf::loadView($viewName, ['orders' => $orders]);

                    // 5. Return the download response.
                    return response()->streamDownload(
                        fn() => print($pdf->output()),
                        $filename
                    );
                }),
        ];
    }
}
