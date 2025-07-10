<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinancialReportResource\Pages;
use App\Filament\Resources\FinancialReportResource\RelationManagers;
use App\Models\FinancialReport;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinancialReportResource extends Resource
{
    protected static ?string $model = FinancialReport::class;

    protected static ?string $navigationLabel = 'Keuangan';

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';

    protected static ?string $modelLabel = 'Keuangan';

    protected static ?string $pluralModelLabel = 'Keuangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('vehicle_id')
                    ->label('Nama Kendaraan')
                    ->options(
                        // Ambil semua kendaraan dan ubah formatnya
                        Vehicle::all()->mapWithKeys(function ($vehicle) {
                            // Kembalikan array dengan format [id => 'Brand Model']
                            return [$vehicle->id => "{$vehicle->brand} {$vehicle->model}: {$vehicle->license_plate}"];
                        })
                    )
                    ->required(),
                DateTimePicker::make('transaction_date')
                    ->label('Tanggal Transaksi')
                    ->required(),
                TextInput::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->maxLength(255),
                Select::make('type')
                    ->options([
                        'income' => 'Pemasukan',
                        'expense' => 'Pengeluaran',
                    ])
                    ->required(),
                TextInput::make('amount')
                    ->label('Jumlah')
                    ->required(),
                Select::make('category')
                    ->options([
                        'rental' => 'Penyewaan',
                        'maintenance' => 'Pemeliharaan',
                        'other' => 'Lainnya',
                    ])
                    ->required(),
                TextInput::make('notes')
                    ->label('Catatan (opsional)')
                    ->maxLength(255),
                Hidden::make('created_by')
                    ->default(function () {
                        $user = Auth::user();
                        return $user->employee?->id ?? $user->id;
                    }),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction_date')
                    ->label('Tanggal Transaksi')
                    ->state(function ($record) {
                        return $record->transaction_date;
                    })
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->locale('id')->isoFormat('dddd, D MMMM Y'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle.brand')
                    ->label("Nama Kendaraan")
                    ->formatStateUsing(fn ($state, $record) => $record->vehicle->brand . ' ' . $record->vehicle->model),
                Tables\Columns\TextColumn::make('vehicle.license_plate')
                    ->label('Plat Kendaraan'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->state(function ($record) {
                        if ($record->type == 'income') {
                            return 'Pemasukan';
                        } else {
                            return 'Pengeluaran';
                        }
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->state(function ($record) {
                        return 'Rp' . number_format($record->amount, 0, ',', '.');
                    }),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('notes')
                    ->label('Catatan'),
                Tables\Columns\TextColumn::make('employee.user.name')
                    ->label('Dibuat oleh')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipe')
                    ->options([
                        'income' => 'Pemasukan',
                        'expense' => 'Pengeluaran'
                    ]),
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'rental' => 'Penyewaan',
                        'maintenance' => 'Pemeliharaan',
                        'other' => 'lainnya'
                    ]),
                Filter::make('vehicle')
                    ->form([
                        // 1. Brand Selector (Triggers Model)
                        Forms\Components\Select::make('brand')
                            ->label('Brand')
                            ->options(
                                Vehicle::pluck('brand', 'brand')->unique()
                            )
                            ->live(), // Makes this field reactive

                        // 2. Model Selector (Appears after Brand, Triggers License Plate)
                        Forms\Components\Select::make('model')
                            ->label('Model')
                            ->hidden(fn(Forms\Get $get): bool => empty($get('brand'))) // Hidden until brand is selected
                            ->options(function (Forms\Get $get): array {
                                if (empty($get('brand'))) {
                                    return [];
                                }
                                // Load models for the selected brand
                                return Vehicle::where('brand', $get('brand'))->pluck('model', 'model')->unique()->toArray();
                            })
                            ->live(), // Makes this field reactive

                        // 3. License Plate Selector (Appears after Model)
                        Forms\Components\Select::make('license_plate')
                            ->label('License Plate')
                            // Hidden until both brand AND model are selected
                            ->hidden(fn(Forms\Get $get): bool => empty($get('brand')) || empty($get('model')))
                            ->options(function (Forms\Get $get): array {
                                if (empty($get('model'))) {
                                    return [];
                                }
                                // Load license plates for the selected brand and model
                                return Vehicle::where('brand', $get('brand'))
                                    ->where('model', $get('model'))
                                    ->pluck('license_plate', 'license_plate')
                                    ->toArray();
                            }),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['brand'],
                                fn(Builder $query, $brand): Builder => $query->whereHas('vehicle', fn($q) => $q->where('brand', 'like', "%{$brand}%"))
                            )
                            ->when(
                                $data['model'],
                                fn(Builder $query, $model): Builder => $query->whereHas('vehicle', fn($q) => $q->where('model', 'like', "%{$model}%"))
                            )
                            ->when(
                                $data['license_plate'],
                                fn(Builder $query, $plate): Builder => $query->whereHas('vehicle', fn($q) => $q->where('license_plate', 'like', "%{$plate}%"))
                            );
                    }),

                SelectFilter::make('transaction_date')
                    ->label('Bulan Transaksi')
                    ->options([
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (isset($data['value'])) {
                            return $query->whereMonth('transaction_date', $data['value']);
                        }
                        return $query;
                    }),

                SelectFilter::make('year') // A unique name for the filter
                    ->label('Booking Year')
                    ->options(function () {
                        // Dynamically get all unique years from your orders table
                        return FinancialReport::select(DB::raw('YEAR(transaction_date) as year'))
                            ->distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year', 'year')
                            ->toArray();
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        if (!empty($data['value'])) {
                            return $query->whereYear('transaction_date', $data['value']);
                        }
                        return $query;
                    }),
            ])
            ->actions([])
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
            'index' => Pages\ListFinancialReports::route('/'),
            'create' => Pages\CreateFinancialReport::route('/create'),
            'edit' => Pages\EditFinancialReport::route('/{record}/edit'),
        ];
    }
}
