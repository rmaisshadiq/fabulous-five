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
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;

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
            // Bikin Section biar UI adminnya ada kotaknya dan rapi
            Section::make('Informasi Kendaraan')
                ->schema([
                    FileUpload::make('vehicle_image')
                        ->image()
                        ->directory('vehicles')
                        ->required()
                        ->columnSpanFull(), // Pake ini biar ngelebar penuh (lebih rapi dari columnSpan(2))

                    Grid::make(2)->schema([
                        TextInput::make('brand')
                            ->required()
                            ->live(debounce: 500) // OPTIMASI: Kasih debounce biar ga query ke DB setiap mencet 1 huruf, nunggu user stop ngetik 0.5 detik
                            ->datalist(function () {
                                return Vehicle::pluck('brand')->unique()->toArray();
                            }),
                            
                        TextInput::make('model')
                            ->required()
                            ->datalist(function (Get $get) {
                                $brand = $get('brand');
                                if ($brand) {
                                    return Vehicle::where('brand', $brand)
                                        ->pluck('model')
                                        ->unique()
                                        ->toArray();
                                }
                                return Vehicle::pluck('model')->unique()->toArray();
                            }),
                            
                        TextInput::make('car_type')
                            ->required(),
                            
                        TextInput::make('license_plate')
                            ->required(),
                    ]),
                ]),

            Section::make('Harga & Status')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('price_per_day')
                            ->label('Harga per Hari (Reguler)')
                            ->required()
                            ->numeric() // OPTIMASI: Pake bawaan Filament aja
                            ->prefix('Rp'),
                            // Catatan: Script x-data x-on:input formatRupiah lu gw hapus. 
                            // Soalnya kalau inputnya jadi ada titik (contoh: 150.000) trus di-save ke kolom Integer di DB, 
                            // Laravel bisa error kena truncate atau salah simpen data. 
                            // Mending pake numeric() bawaan biar aman pas disimpen.
                            
                        Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'maintenance' => 'In Maintenance',
                                'rented' => 'Rented',
                            ])
                            ->required()
                            ->default('active'),
                    ]),
                ]),

            // SECTION BARU KHUSUS BEST DEAL
            Section::make('Paket Best Deal (All-In)')
                ->description('Aktifkan ini untuk memunculkan input harga paket khusus kendaraan ini.')
                ->schema([
                    Toggle::make('is_best_deal')
                        ->label('Jadikan Mobil Best Deal?')
                        ->live(), // Wajib live() biar pas di-klik, form di bawahnya muncul

                    // Kotak Harga Paket ini cuma MUNCUL kalau toggle di atas aktif
                    Grid::make(2)
                        ->visible(fn (Get $get) => $get('is_best_deal')) 
                        ->schema([
                            TextInput::make('harga_drop_bandara')
                                ->label('Harga Drop Bandara')
                                ->numeric()
                                ->prefix('Rp')
                                ->required(fn (Get $get) => $get('is_best_deal')), // Wajib diisi kalau statusnya Best Deal
                                
                            TextInput::make('harga_city_tour')
                                ->label('Harga City Tour (8 Jam)')
                                ->numeric()
                                ->prefix('Rp')
                                ->required(fn (Get $get) => $get('is_best_deal')),
                                
                            TextInput::make('harga_full_day')
                                ->label('Harga Full Day (12 Jam)')
                                ->numeric()
                                ->prefix('Rp')
                                ->required(fn (Get $get) => $get('is_best_deal')),
                                
                            TextInput::make('harga_luar_kota')
                                ->label('Harga Luar Kota')
                                ->numeric()
                                ->prefix('Rp')
                                ->required(fn (Get $get) => $get('is_best_deal')),
                        ]),
                ]),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('vehicle_image')
                    ->label('Foto Kendaraan')
                    ->width(200)
                    ->height(200),
                Tables\Columns\TextColumn::make('brand')
                    ->label('Merk Kendaraan')
                    ->state(function ($record) {
                        return $record->brand . ' ' . $record->model;
                    }),
                Tables\Columns\TextColumn::make('license_plate')
                    ->label('Plat Kendaraan'),
                Tables\Columns\TextColumn::make('price_per_day')
                    ->label('Harga per Hari')
                    ->state(function ($record) {
                        return 'Rp' . number_format($record->price_per_day, 0, ',', '.');
                    }),
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
