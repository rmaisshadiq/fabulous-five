<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DriverResource\Pages;
use App\Filament\Resources\DriverResource\RelationManagers;
use App\Models\Driver;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Peran';

    protected static ?string $navigationLabel = 'Supir';

    protected static ?string $modelLabel = 'Supir';

    protected static ?string $pluralModelLabel = 'Supir';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('employee_id')
                    ->label('Nama Karyawan')
                    ->relationship(
                        'employee',
                        'id',
                        fn(Builder $query) =>
                        $query->whereHas('user')->whereDoesntHave('driver')
                    )
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->user->name)
                    ->required(),
                TextInput::make('license_number')
                    ->label('Nomor SIM')
                    ->maxLength(16)
                    ->required(),
                Select::make('available_status')
                    ->label("Status Ketersediaan")
                    ->options([
                        'available' => 'Tersedia',
                        'not available' => 'Tidak Tersedia'
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('employee.user.profile_image')
                    ->label('Foto Karyawan')
                    ->width(150)
                    ->height(150),
                Tables\Columns\TextColumn::make('employee.user.name')
                    ->label('Nama Karyawan'),
                Tables\Columns\TextColumn::make('license_number')
                    ->label('Nomor SIM'),
                Tables\Columns\TextColumn::make('available_status')
                    ->label("Status Ketersediaan")
                    ->formatStateUsing(fn ($state) => $state == 'available' ? 'Tersedia' : 'Tidak Tersedia'),
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
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }
}
