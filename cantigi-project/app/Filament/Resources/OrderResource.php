<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\ReturnLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
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
                Select::make('customer_id')
                    ->relationship('customer.user', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->disabled(fn($context) => $context === 'edit'),


                Select::make('vehicle_id')
                    ->relationship('vehicle')
                    ->options(
                        \App\Models\Vehicle::all()
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
                    ->required()
                    ->disabled(fn($context) => $context === 'edit'),

                DatePicker::make('end_booking_date')
                    ->required()
                    ->disabled(fn($context) => $context === 'edit'),

                TimePicker::make('start_booking_time')
                    ->required()
                    ->disabled(fn($context) => $context === 'edit'),

                TimePicker::make('end_booking_time')
                    ->required()
                    ->disabled(fn($context) => $context === 'edit'),

                Textarea::make('drop_address')
                    ->required()
                    ->rows(3)
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

                Select::make('driver_id')
                    ->relationship('driver.employee.user', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                // ->visible(fn($get) => in_array($get('status'), ['confirmed', 'in_progress', 'completed'])),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.user.name')
                    ->label('Nama Penyema')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('customer.user.email')
                    ->label('Email Penyema')
                    ->searchable()
                    ->sortable(),

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
                    ->state(function ($record) {
                        return 'Rp' . $record->getFormattedFinalTotalAttribute();
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

                SelectFilter::make('vehicle.brand')
                    ->relationship('vehicle', 'brand')
                    ->label('Jenis Mobil'),

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
