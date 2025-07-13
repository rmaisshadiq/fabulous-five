<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Peran';

    protected static ?string $navigationLabel = 'Pelanggan';

    protected static ?string $modelLabel = 'Pelanggan';

    protected static ?string $pluralModelLabel = 'Pelanggan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Pelanggan')
                    ->required()
                    // Disable the field if the record exists and has a related user
                    ->disabled(fn(?Model $record): bool => $record && $record->user()->exists())
                    // This method runs after the form is filled with data from the database
                    ->afterStateHydrated(function (TextInput $component, ?Model $record) {
                        // If there's no record or no user, do nothing.
                        if (!$record || !$record->user) {
                            return;
                        }

                        // Set the input's value to the user's name and make it non-dehydrated.
                        $component->state($record->user->name)
                            ->dehydrated(false);
                    }),
                TextInput::make('phone_number')
                    ->label('Nomor HP')
                    ->placeholder('081234567890')
                    ->required()
                    ->rules([
                        // Use a closure for custom validation
                        function () {
                            return function (string $attribute, mixed $value, Closure $fail) {
                                // 1. Remove hyphens and any other non-numeric characters from the input.
                                $numericValue = preg_replace('/[^0-9]/', '', $value);

                                // 2. Test the clean, numeric-only value against your original regex.
                                if (!preg_match('/^(08)[1-9][0-9]{7,10}$/', $numericValue)) {
                                    // 3. Fail validation if it does not match.
                                    $fail('Format Nomor HP tidak valid.');
                                }
                            };
                        },
                    ])
                    ->validationAttribute('Nomor HP')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(fn(Customer $record): string => $record->user?->name ?? $record->name),
                TextColumn::make('user.phone_number')
                    ->label('Telepon')
                    ->state(function ($record) {
                        if (!$record->phone_number && !$record->user->phone_number) {
                            return 'Belum tersedia';
                        }
                        return $record->user?->phone_number ?? $record->phone_number;
                    }),
                TextColumn::make('verification_status')
                    ->label('Status Verifikasi')
                    ->sortable()
                    ->default('Tidak tersedia'),
            ])
            ->filters([
                //
            ])
            ->actions([
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
