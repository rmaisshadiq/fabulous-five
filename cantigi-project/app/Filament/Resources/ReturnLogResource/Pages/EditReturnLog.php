<?php

namespace App\Filament\Resources\ReturnLogResource\Pages;

use App\Filament\Resources\ReturnLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EditReturnLog extends EditRecord
{
    protected static string $resource = ReturnLogResource::class;

    public function getTitle(): string
    {
        return 'Konfirmasi Pengembalian';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['handler_id'] = Auth::user()->employee?->id ?? Auth::user()->id;

        $data['status'] = 'completed';
        return $data;
    }

    protected function afterSave(): void
    {
        // Update the order status to completed
        if ($this->record->order) {
            $this->record->order->update(['status' => 'completed']);
        }

        // Update the vehicle status to available
        if ($this->record->vehicle) {
            $this->record->vehicle->update(['status' => 'active']);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
