<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReturnLogResource\Pages;
use App\Filament\Resources\ReturnLogResource\RelationManagers;
use App\Models\ReturnLog;
use DateTime;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ReturnLogResource extends Resource
{
    protected static ?string $model = ReturnLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    protected static function mutateFormDataBeforeSave(array $data): array
    {
        // Add this line to force the status to 'completed'
        $data['status'] = 'completed';

        return $data;
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DateTimePicker::make('returned_at')
                    ->label('Dikembalikan pada:')
                    ->required(),
                TextInput::make('fuel_level_on_rent')
                    ->label('BBM pada saat disewa')
                    ->required()
                    ->suffix('Liter'),
                TextInput::make('fuel_level_on_return')
                    ->label('BBM pada saat dikembalikan')
                    ->required()
                    ->suffix('Liter'),
                TextInput::make('notes')
                    ->label('Catatan'),
                Hidden::make('status')
                    ->default('completed'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_id')
                    ->label('Order ID')
                    ->sortable(),
                TextColumn::make('vehicle_id')
                    ->label('Nama Kendaraan')
                    ->formatStateUsing(fn ($record) => $record->vehicle->brand . ' ' . $record->vehicle->model)
                    ->sortable(),
                TextColumn::make('employee.user.name')
                    ->label('Karyawan yang Bertanggungjawab')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('returned_at')
                    ->label('Tanggal Pengembalian')
                    ->sortable()
                    ->date('d-m-Y'),
                 TextColumn::make('fuel_level_on_rent')
                    ->label('Tingkat BBM sebelum disewa'),
                TextColumn::make('fuel_level_on_return')
                    ->label('Tingkat BBM setelah disewa'),
                TextColumn::make('notes')
                    ->label('Catatan'),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Konfirmasi Pengembalian')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn($record) => $record->status !== 'completed'),
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
            'index' => Pages\ListReturnLogs::route('/'),
            'create' => Pages\CreateReturnLog::route('/create'),
            'edit' => Pages\EditReturnLog::route('/{record}/edit'),
        ];
    }
}
