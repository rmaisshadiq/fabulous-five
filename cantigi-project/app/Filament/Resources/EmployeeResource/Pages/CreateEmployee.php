<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Customer;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate()
    {
        $employee = $this->record;
        $roles = $this->data['roles'];
        $userId = $employee->user_id;
        $user = User::find($userId);

        if ($userId) {
            Customer::where('user_id', $userId)->delete();
        }

        if ($user && !empty($roles)) {
            $user->syncRoles($roles);
        }
    }
}
