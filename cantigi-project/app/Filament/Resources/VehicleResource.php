<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Filament\Resources\VehicleResource\RelationManagers;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Mask;
use Filament\Forms\Get;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Rental';
    protected static ?string $navigationLabel = 'Kendaraan';
    protected static ?string $modelLabel = 'Kendaraan';

    protected static ?string $pluralModelLabel = 'Kendaraan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('vehicle_image')
                    ->image()
                    ->directory('vehicles')
                    ->required()
                    ->columnSpan(2),
                TextInput::make('brand')
                    ->required()
                    ->live() // Makes the field reactive to update the model suggestions
                    ->datalist(
                        // Provides suggestions from all unique brands in the database
                        Vehicle::pluck('brand')->unique()->toArray()
                    ),
                TextInput::make('car_type')
                    ->required(),
                TextInput::make('model')
                    ->required()
                    ->datalist(function (Get $get) {
                        $brand = $get('brand');

                        // If a brand has been entered, show models for that brand
                        if ($brand) {
                            return Vehicle::where('brand', $brand)
                                ->pluck('model')
                                ->unique()
                                ->toArray();
                        }

                        // Otherwise, show all unique models as a fallback
                        return Vehicle::pluck('model')->unique()->toArray();
                    }),
                TextInput::make('license_plate')
                    ->required(),
                DatePicker::make('purchase_date')
                    ->format('Y/m/d'),
                DatePicker::make('last_maintenance_date')
                    ->format('Y/m/d'),
                TextInput::make('price_per_day')
                    ->label('Harga per Hari')
                    ->required()
                    ->extraAttributes([
                        'x-data' => '',
                        'x-on:input' => 'formatRupiah($event)',
                        'inputmode' => 'numeric',
                    ])
                    ->prefix('Rp '),

                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'maintenance' => 'In Maintenance',
                        'rented' => 'Rented',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('vehicle_image')
                    ->width(200)
                    ->height(200),
                Tables\Columns\TextColumn::make('brand'),
                Tables\Columns\TextColumn::make('license_plate'),
                Tables\Columns\TextColumn::make('purchase_date'),
                Tables\Columns\TextColumn::make('last_maintenance_date'),
                Tables\Columns\TextColumn::make('price_per_day'),
                Tables\Columns\TextColumn::make('status')

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
