<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaintenanceResource\Pages;
use App\Filament\Resources\MaintenanceResource\RelationManagers;
use App\Models\Maintenance;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class MaintenanceResource extends Resource
{
    protected static ?string $model = Maintenance::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationGroup = 'Rental';

    protected static ?string $navigationLabel = 'Pemeliharaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('vehicle_id')
                    ->label('Nama Kendaraan')
                    ->options(Vehicle::all()->pluck('model', 'id'))
                    ->searchable()
                    ->required()
                    ->preload(),
                
                DatePicker::make('maintenance_date')
                    ->label('Tanggal Pemeliharaan')
                    ->required(),

                TextInput::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->maxLength(255),
                    
                TextInput::make('cost')
                    ->label('Harga Maintenance')
                    ->required()
                    ->extraAttributes([
                        'x-data' => '',
                        'x-on:input' => 'formatRupiah($event)',
                        'inputmode' => 'numeric',
                    ])
                    ->prefix('Rp '),

                Hidden::make('status')
                    ->default('in_progress'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vehicle.name')
                    ->label('Nama Kendaraan')
                    ->state(fn ($record) => $record->vehicle->brand . ' ' . $record->vehicle->model)
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('maintenance_date')
                    ->label('Tanggal Pemeliharaan')
                    ->date('d F Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('cost')
                    ->label('Harga Maintenance')
                    ->money('IDR', true)
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('vehicle_id')
                    ->label('Kendaraan')
                    ->options(Vehicle::all()->pluck('license_plate', 'id'))
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\Action::make('complete')
                    ->label('Complete')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(condition: fn($record) => $record->status === 'in_progress')
                    ->requiresConfirmation()
                    ->modalHeading('Complete Maintenance')
                    ->modalDescription('Are you sure you want to complete this order?')
                    ->modalSubmitActionLabel('Yes, Complete')
                    ->action(function ($record) {
                        // Update customer verification status
                        $record->update([
                            'status' => 'completed'
                        ]);

                        Vehicle::where('id', $record->vehicle_id)->update([
                            'status' => 'active'
                        ]);

                        // Show success notification
                        Notification::make()
                            ->title('Pemeliharaan berhasil diselesaikan!')
                            ->body('Kendaraan bisa digunakan kembali!')
                            ->success()
                            ->send();
                    }),
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
            'index' => Pages\ListMaintenances::route('/'),
            'create' => Pages\CreateMaintenance::route('/create'),
            'edit' => Pages\EditMaintenance::route('/{record}/edit'),
        ];
    }
}