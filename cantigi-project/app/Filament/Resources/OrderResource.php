<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
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

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    
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
                    ->disabled(fn ($context) => $context === 'edit'),

                Select::make('vehicle_id')
                    ->relationship('vehicles', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->disabled(fn ($context) => $context === 'edit'),

                DatePicker::make('start_booking_date')
                    ->required()
                    ->disabled(fn ($context) => $context === 'edit'),

                DatePicker::make('end_booking_date')
                    ->required()
                    ->disabled(fn ($context) => $context === 'edit'),

                TimePicker::make('start_booking_time')
                    ->required()
                    ->disabled(fn ($context) => $context === 'edit'),

                TimePicker::make('end_booking_time')
                    ->required()
                    ->disabled(fn ($context) => $context === 'edit'),

                Textarea::make('drop_address')
                    ->required()
                    ->rows(3)
                    ->disabled(fn ($context) => $context === 'edit'),

                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('pending'),

                Select::make('driver_id')
                    ->relationship('drivers.user', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->visible(fn ($get) => in_array($get('status'), ['confirmed', 'in_progress'])),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable(),

                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable(query: function ($query, $search) {
                        return $query->whereHas('customer.user', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(),

                TextColumn::make('vehicle_name')
                    ->label('Vehicle')
                    ->searchable(query: function ($query, $search) {
                        return $query->whereHas('vehicles', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(),

                TextColumn::make('start_booking_date')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('end_booking_date')
                    ->label('End Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('start_booking_time')
                    ->label('Start Time')
                    ->time(),

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
                        'success' => 'confirmed',
                        'primary' => 'in_progress',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
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
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}