<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinancialReportResource\Pages;
use App\Filament\Resources\FinancialReportResource\RelationManagers;
use App\Models\FinancialReport;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class FinancialReportResource extends Resource
{
    protected static ?string $model = FinancialReport::class;

    protected static ?string $navigationLabel = 'Keuangan';

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Tables\Columns\TextColumn::make('transaction_time')
                    ->label('Jam Transaksi')
                    ->state(function ($record) {
                        return $record->transaction_date;
                    })
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->locale('id')->isoFormat('HH:mm'))
                    ->sortable(),
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
            'index' => Pages\ListFinancialReports::route('/'),
            'create' => Pages\CreateFinancialReport::route('/create'),
            'edit' => Pages\EditFinancialReport::route('/{record}/edit'),
        ];
    }
}
