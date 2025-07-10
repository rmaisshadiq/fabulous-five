<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Customer;
use App\Models\Order;
use App\Models\ReturnLog;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $navigationLabel = 'Pemesanan';

    protected static ?string $modelLabel = 'Pemesanan';

    protected static ?string $pluralModelLabel = 'Pemesanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Pemesanan')
                    ->schema(components: [
                        Select::make('customer_id')
                            ->label('Nama Pelanggan')
                            ->required()
                            ->disabled(fn($context) => $context === 'edit')
                            ->searchable() // Keep this for the UI, but the logic is in getSearchResultsUsing

                            // Manually define the list of options from two sources
                            ->options(function (): array {
                                // 1. Get customers who have a name via the User relationship
                                $customersFromUser = Customer::whereHas('user')->with('user')->get()->mapWithKeys(
                                    fn($customer) =>
                                    [$customer->id => $customer->user->name]
                                );

                                // 2. Get customers who have their own 'name' and no user relationship
                                $customersFromOwnName = Customer::whereDoesntHave('user')->whereNotNull('name')->get()->mapWithKeys(
                                    fn($customer) =>
                                    [$customer->id => $customer->name]
                                );

                                // 3. Combine the two lists
                                return $customersFromUser->union($customersFromOwnName)->all();
                            })

                            // Define the custom search logic
                            ->getSearchResultsUsing(function (string $search): array {
                                $customersFromUser = Customer::whereHas(
                                    'user',
                                    fn($query) =>
                                    $query->where('name', 'like', "%{$search}%")
                                )->with('user')->limit(50)->get()->mapWithKeys(
                                    fn($customer) =>
                                    [$customer->id => $customer->user->name]
                                );

                                $customersFromOwnName = Customer::whereDoesntHave('user')
                                    ->where('name', 'like', "%{$search}%")
                                    ->limit(50)
                                    ->get()->mapWithKeys(
                                        fn($customer) =>
                                        [$customer->id => $customer->name]
                                    );

                                return $customersFromUser->union($customersFromOwnName)->all();
                            })

                            // Define how to get the label for a pre-selected value (replaces preload)
                            ->getOptionLabelUsing(function ($value): ?string {
                                $customer = Customer::with('user')->find($value);
                                // Return the user's name if it exists, otherwise return the customer's own name
                                return $customer->user->name ?? $customer->name;
                            }),


                        Select::make('vehicle_id')
                            ->label('Nama Kendaraan')
                            ->relationship('vehicle')
                            ->options(
                                Vehicle::all()
                                    ->mapWithKeys(function ($v) {
                                        return [
                                            $v->id => "{$v->brand} {$v->model} ({$v->license_plate})",
                                        ];
                                    })
                                    ->toArray()
                            )
                            ->required()
                            ->searchable()
                            ->preload()
                            ->disabled(fn($context) => $context === 'edit'),

                        DatePicker::make('start_booking_date')
                            ->label('Tanggal Pemesanan')
                            ->required()
                            ->disabled(fn($context) => $context === 'edit'),

                        DatePicker::make('end_booking_date')
                            ->label('Tanggal Pengembalian')
                            ->required()
                            ->disabled(fn($context) => $context === 'edit'),

                        TimePicker::make('start_booking_time')
                            ->label('Jam Pemesanan')
                            ->required()
                            ->disabled(fn($context) => $context === 'edit'),

                        TimePicker::make('end_booking_time')
                            ->label('Jam Pengembalian')
                            ->required()
                            ->disabled(fn($context) => $context === 'edit'),

                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'in_progress' => 'In Progress',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->default('pending')
                            ->reactive()
                            ->afterStateUpdated(function ($state, $record) {
                                if ($record && $state === 'confirmed') {
                                    Notification::make()
                                        ->title('Order Confirmed')
                                        ->body('The order has been confirmed. You can now assign a driver.')
                                        ->success()
                                        ->send();
                                }
                            }),

                        TextInput::make('amount')
                            ->label('Total Harga')
                            ->dehydrated(false)
                            ->required(),

                        Select::make('payment_type')
                            ->label('Opsi Pembayaran')
                            ->options([
                                'cash' => 'Tunai',
                                'bank_transfer' => 'Transfer Bank',
                                'qris' => 'QRIS'
                            ])
                            ->dehydrated(false)
                            ->required(),
                    ]),

                Section::make('Detail Pengembalian')
                    ->schema(components: [
                        DateTimePicker::make('returned_at')
                            ->label('Dikembalikan pada:')
                            ->dehydrated(false), // Don't save this to the 'orders' table

                        TextInput::make('fuel_level_on_rent')
                            ->label('Tingkat BBM saat disewa')
                            ->dehydrated(false), // Don't save this to the 'orders' table

                        TextInput::make('fuel_level_on_return')
                            ->label('Tingkat BBM saat dikembalikan')
                            ->dehydrated(false), // Don't save this to the 'orders' table
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_name') // Use a unique, virtual name for the column
                    ->label('Nama Pelanggan')
                    // 1. Custom Display Logic
                    ->state(function (Model $record): ?string {
                        // Prioritize the user's name, fall back to the customer's own name
                        return $record->customer?->user?->name ?? $record->customer?->name;
                    })
                    // 2. Custom Search Logic
                    ->searchable([
                        'customer.user.name',
                        'customer.name',
                    ])
                    // 3. Custom Sort Logic
                    ->sortable([
                        'customer.user.name',
                        'customer.name',
                    ]),

                TextColumn::make('customer.phone_number')
                    ->label('Nomor HP')
                    ->searchable()
                    ->sortable()
                    ->default('Tidak tersedia'),

                TextColumn::make('vehicle.model')
                    ->label('Jenis Mobil')
                    ->formatStateUsing(fn($record) => $record->vehicle->brand . ' ' . $record->vehicle->model)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('vehicle.license_plate')
                    ->label('Plat Nomor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('start_booking_date_day')
                    ->label('Hari Pemesanan')
                    ->state(function ($record) {
                        return $record->start_booking_date;
                    })
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->locale('id')->isoFormat('dddd')),

                TextColumn::make('start_booking_date')
                    ->label('Tanggal Pemesanan')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('start_booking_time')
                    ->label('Jam Pemesanan')
                    ->time('H:i'),

                TextColumn::make('return_log.fuel_level_on_rent')
                    ->label('BBM sebelum disewa')
                    ->suffix(' liter'),

                TextColumn::make('return_log.returned_at')
                    ->label('Tanggal Pengembalian')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('return_log.returned_at_time')
                    ->label('Jam Pengembalian')
                    ->state(function ($record) {
                        return $record->return_log?->returned_at;
                    })
                    ->time('H:i')
                    ->sortable(),

                TextColumn::make('return_log.fuel_level_on_return')
                    ->label('BBM setelah disewa')
                    ->suffix(' liter'),

                TextColumn::make('amount')
                    ->label('Total Biaya')
                    ->state(function (Model $record): ?string {
                        // 1. Ambil nilai numeriknya terlebih dahulu
                        $amount = $record->financial_report?->amount ?? $record->getFinalTotalAttribute(); // Pastikan ini mengembalikan angka

                        // 2. Jika nilainya ada, format ke Rupiah. Jika tidak, tampilkan '-' atau null.
                        if (is_null($amount)) {
                            return null; // atau return '-';
                        }

                        // 3. Format dengan 'Rp ', pemisah ribuan '.', dan 0 desimal
                        return 'Rp' . number_format($amount, 0, ',', '.');
                    }),

                BadgeColumn::make('status')
                    ->label('Keterangan')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'confirmed',
                        'info' => 'in_progress',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'in_progress' => 'In Progress',
                        'due' => 'Due',
                        'completed' => 'Completed',
                    ]),

                Filter::make('vehicle')
                    ->form([
                        // 1. Brand Selector (Triggers Model)
                        Forms\Components\Select::make('brand')
                            ->label('Brand')
                            ->options(
                                Vehicle::pluck('brand', 'brand')->unique()
                            )
                            ->live()
                            ->afterStateUpdated(function (Forms\Set $set, $state) {
                                // Reset dependent fields when brand changes
                                $set('model', null);
                                $set('license_plate', null);
                            }),

                        // 2. Model Selector (Appears after Brand, Triggers License Plate)
                        Forms\Components\Select::make('model')
                            ->label('Model')
                            ->hidden(fn(Forms\Get $get): bool => empty($get('brand')))
                            ->options(function (Forms\Get $get): array {
                                if (empty($get('brand'))) {
                                    return [];
                                }
                                return Vehicle::where('brand', $get('brand'))->pluck('model', 'model')->unique()->toArray();
                            })
                            ->live()
                            ->afterStateUpdated(function (Forms\Set $set, $state) {
                                // Reset license plate when model changes
                                $set('license_plate', null);
                            }),

                        // 3. License Plate Selector (Appears after Model)
                        Forms\Components\Select::make('license_plate')
                            ->label('License Plate')
                            ->hidden(fn(Forms\Get $get): bool => empty($get('brand')) || empty($get('model')))
                            ->options(function (Forms\Get $get): array {
                                if (empty($get('model')) || empty($get('brand'))) {
                                    return [];
                                }
                                return Vehicle::where('brand', $get('brand'))
                                    ->where('model', $get('model'))
                                    ->pluck('license_plate', 'license_plate')
                                    ->toArray();
                            }),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                !empty($data['brand']),
                                fn(Builder $query): Builder => $query->whereHas('vehicle', fn($q) => $q->where('brand', $data['brand']))
                            )
                            ->when(
                                !empty($data['model']) && !empty($data['brand']),
                                fn(Builder $query): Builder => $query->whereHas('vehicle', fn($q) => $q->where('brand', $data['brand'])->where('model', $data['model']))
                            )
                            ->when(
                                !empty($data['license_plate']) && !empty($data['model']) && !empty($data['brand']),
                                fn(Builder $query): Builder => $query->whereHas(
                                    'vehicle',
                                    fn($q) =>
                                    $q->where('brand', $data['brand'])
                                        ->where('model', $data['model'])
                                        ->where('license_plate', $data['license_plate'])
                                )
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if (!empty($data['brand'])) {
                            $indicators[] = Indicator::make('Brand: ' . $data['brand']);
                        }

                        if (!empty($data['model'])) {
                            $indicators[] = Indicator::make('Model: ' . $data['model']);
                        }

                        if (!empty($data['license_plate'])) {
                            $indicators[] = Indicator::make('License Plate: ' . $data['license_plate']);
                        }

                        return $indicators;
                    }),

                SelectFilter::make('start_booking_date')
                    ->label('Booking Month')
                    ->options([
                        '01' => 'January',
                        '02' => 'February',
                        '03' => 'March',
                        '04' => 'April',
                        '05' => 'May',
                        '06' => 'June',
                        '07' => 'July',
                        '08' => 'August',
                        '09' => 'September',
                        '10' => 'October',
                        '11' => 'November',
                        '12' => 'December',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (isset($data['value'])) {
                            return $query->whereMonth('start_booking_date', $data['value']);
                        }
                        return $query;
                    }),

                SelectFilter::make('year') // A unique name for the filter
                    ->label('Booking Year')
                    ->options(function () {
                        // Dynamically get all unique years from your orders table
                        return Order::select(DB::raw('YEAR(start_booking_date) as year'))
                            ->distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year', 'year')
                            ->toArray();
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        if (!empty($data['value'])) {
                            return $query->whereYear('start_booking_date', $data['value']);
                        }
                        return $query;
                    }),


            ])
            ->actions([
                Tables\Actions\Action::make('verify')
                    ->label('Confirm')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(condition: fn($record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Confirm Order')
                    ->modalDescription('Are you sure you want to confirm this order?')
                    ->modalSubmitActionLabel('Yes, Confirm')
                    ->action(function ($record) {
                        // Update customer verification status
                        $record->update([
                            'status' => 'confirmed'
                        ]);

                        // Show success notification
                        Notification::make()
                            ->title('Order Confirmed Successfully')
                            ->body('The order has been confirmed.')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('complete')
                    ->label('Complete')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(condition: fn($record) => $record->status === 'in_progress')
                    ->requiresConfirmation()
                    ->modalHeading('Complete Order')
                    ->modalDescription('Are you sure you want to complete this order?')
                    ->modalSubmitActionLabel('Yes, Complete')
                    ->action(function ($record) {
                        // Update customer verification status
                        $record->update([
                            'status' => 'due'
                        ]);

                        ReturnLog::create([
                            'order_id' => $record->id,
                            'vehicle_id' => $record->vehicle_id,
                            'handler_id' => null,
                            'status' => 'pending',
                        ]);

                        // Show success notification
                        Notification::make()
                            ->title('Order Completed Successfully')
                            ->body('The order has been completed.')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->requiresConfirmation(),
                ExportBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s'); // Auto-refresh every 30 seconds
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
