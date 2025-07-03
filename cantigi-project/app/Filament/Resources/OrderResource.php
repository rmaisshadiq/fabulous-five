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

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Manajemen Pemesanan';

    protected static ?string $navigationLabel = 'Orders';

    protected static ?string $modelLabel = 'Order';

    protected static ?string $pluralModelLabel = 'Orders';

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
                TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable()
                    ->prefix('#'),

                TextColumn::make('customer.user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('vehicle.model')
                    ->label('Vehicle')
                    ->formatStateUsing(fn ($record) => $record->vehicle->brand . ' ' . $record->vehicle->model)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('start_booking_date')
                    ->label('Start Date')
                    ->date('M d, Y')
                    ->sortable(),

                TextColumn::make('end_booking_date')
                    ->label('End Date')
                    ->date('M d, Y')
                    ->sortable(),

                TextColumn::make('start_booking_time')
                    ->label('Start Time')
                    ->time('H:i'),

                TextColumn::make('drop_address')
                    ->label('Drop Address')
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),

                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'confirmed',
                        'info' => 'in_progress',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->sortable(),

                TextColumn::make('driver.employee.user.name')
                    ->label('Driver')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Kosongkan atau tambahkan filter jika perlu
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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