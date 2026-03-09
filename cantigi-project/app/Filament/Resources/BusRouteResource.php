<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusRouteResource\Pages;
use App\Filament\Resources\BusRouteResource\RelationManagers;
use App\Models\BusRoute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;

class BusRouteResource extends Resource
{
    protected static ?string $model = BusRoute::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Rute')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('rute')
                                ->required()
                                ->columnSpan(2),
                            
                            Select::make('kategori')
                                ->options([
                                    'transfer' => 'Transfer BIM',
                                    'dalam_propinsi' => 'Dalam Propinsi',
                                    'overland' => 'Overland (Luar Propinsi)',
                                ])
                                ->required(),
                                
                            TextInput::make('min_hari')
                                ->label('Minimum Hari')
                                ->numeric()
                                ->default(1)
                                ->required()
                                ->helperText('Isi 1 untuk rute biasa. Sesuaikan untuk rute Overland (misal Bali: 14)'),
                        ]),
                    ]),

                Section::make('Daftar Harga Berdasarkan Tipe Bus')
                    ->description('Masukkan harga untuk masing-masing tipe bus di rute ini.')
                    ->schema([
                        // Pake REPEATER biar Admin gampang nambahin/edit harga relasi
                        Repeater::make('prices')
                            ->relationship() // Otomatis nge-save ke tabel bus_route_prices
                            ->schema([
                                Select::make('tipe_bus')
                                    ->options([
                                        'hiace_elf' => 'Hiace / Elf (8-14 Seat)',
                                        'medium' => 'Medium (27-29 Seat)',
                                        'of' => 'OF (31-33 Seat)',
                                        'oh' => 'OH (44-47 Seat)',
                                    ])
                                    ->required()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems(), // Biar ga ada opsi bus yang dipilih dobel
                                
                                TextInput::make('harga')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(4) // Langsung nyediain 4 baris form kosong
                            ->addActionLabel('Tambah Harga Tipe Bus'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rute')->searchable(),
                TextColumn::make('kategori')->badge(), // badge() biar tampilannya jadi pill berwarna
                TextColumn::make('min_hari')->label('Min. Hari'),
                TextColumn::make('prices_count')
                    ->counts('prices')
                    ->label('Total Varian Harga'),
            ])
            ->filters([
                // Boleh ditambahin filter kategori nanti
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBusRoutes::route('/'),
            'create' => Pages\CreateBusRoute::route('/create'),
            'edit' => Pages\EditBusRoute::route('/{record}/edit'),
        ];
    }
}
