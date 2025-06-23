<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
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

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // FileUpload::make('portrait')
                //     ->label('Foto Karyawan')
                //     ->image()
                //     ->directory('portraits') // Disimpan di storage/app/public/portraits
                //     ->imageEditor()
                //     ->required(), // Ubah ke ->nullable() jika portrait sudah nullable di DB

                TextInput::make('position')
                    ->label('Jabatan')
                    ->required(),

                TextInput::make('phone')
                    ->label('Nomor Telepon')
                    ->tel()
                    ->required(),

                DatePicker::make('hire_date')
                    ->label('Tanggal Masuk')
                    ->format('Y/m/d')
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'retired' => 'Retired',
                    ])
                    ->required(),

                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->required()
                    ->unique(ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('user.profile_image')
                    ->label('Foto Karyawan')
                    ->width(80)
                    ->height(80),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Karyawan'),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Telepon'),

                Tables\Columns\TextColumn::make('position')
                    ->label('Jabatan'),

                Tables\Columns\TextColumn::make('hire_date')
                    ->label('Tanggal Masuk'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status'),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
