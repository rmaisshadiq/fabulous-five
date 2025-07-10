<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function afterCreate(): void
    {
        // Get the newly created Order record
        $order = $this->record;

        // Get the data from the 'dehydrated' fields
        $returnData = [
            'handler_id' => Auth::user()?->employee?->id,
            'vehicle_id' => $this->data['vehicle_id'],
            'returned_at' => $this->data['returned_at'],
            'fuel_level_on_rent' => $this->data['fuel_level_on_rent'],
            'fuel_level_on_return' => $this->data['fuel_level_on_return'],
            'status' => 'completed'
        ];

        if (!empty(array_filter($returnData))) {
            $order->return_log()->create($returnData);
        }
    }
}
