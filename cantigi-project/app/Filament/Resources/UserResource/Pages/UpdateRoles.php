<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Spatie\Permission\Models\Role;

class UpdateRoles extends Page
{
    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.update-roles';

    // This sets the URL slug for the page
    protected static ?string $slug = 'update-roles';

    public ?array $data = [];

    /**
     * Prepare the form with existing user data when the page loads.
     */
    public function mount(): void
    {
        $users = User::with('roles')->get();

        $userData = $users->map(fn (User $user) => [
            'name' => $user->name,
            'user_id' => $user->id,
            'role' => $user->roles->first()?->name, // Get the user's first role
        ])->toArray();

        $this->form->fill(['users' => $userData]);
    }

    /**
     * Define the form schema.
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('users')
                    ->label('Users')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama User')
                            ->disabled() // Make it read-only
                            ->required(),
                        Select::make('role')
                            ->label('Role')
                            ->options(
                                // Get all roles from filament-shield
                                Role::pluck('name', 'name')
                            )
                            ->required(),
                        // Hidden field to keep track of the user ID
                        TextInput::make('user_id')->hidden(),
                    ])
                    ->columns(2)
                    ->addable(false) // Prevent adding new rows
                    ->deletable(false), // Prevent deleting rows
            ])
            ->statePath('data');
    }

    /**
     * Define the action to save the form data.
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->submit('save'),
        ];
    }

    /**
     * This method is called when the 'save' action is submitted.
     */
    public function save(): void
    {
        $formData = $this->form->getState();

        foreach ($formData['users'] as $userData) {
            $user = User::find($userData['user_id']);
            if ($user) {
                // syncRoles is the best way to assign a single role
                $user->syncRoles($userData['role']);
            }
        }

        Notification::make()
            ->title('Role berhasil diperbarui')
            ->success()
            ->send();
    }
}
