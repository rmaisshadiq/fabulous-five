<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Manajemen Pemesanan';
    protected static ?string $navigationLabel = 'Orders';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('customer_id')
                ->relationship('customer', 'name')
                ->label('Customer')
                ->required(),

            Forms\Components\Select::make('vehicle_id')
                ->relationship('vehicle', 'name')
                ->label('Vehicle')
                ->required(),

            Forms\Components\DatePicker::make('start_booking_date')
                ->label('Tanggal Mulai')
                ->required(),

            Forms\Components\DatePicker::make('end_booking_date')
                ->label('Tanggal Selesai')
                ->required(),

            Forms\Components\TimePicker::make('start_booking_time')
                ->label('Jam Mulai')
                ->required(),

            Forms\Components\TimePicker::make('end_booking_time')
                ->label('Jam Selesai')
                ->required(),

            Forms\Components\Textarea::make('drop_address')
                ->label('Alamat Pengantaran')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable(),

                TextColumn::make('vehicle.name')
                    ->label('Vehicle')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Dipesan pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
