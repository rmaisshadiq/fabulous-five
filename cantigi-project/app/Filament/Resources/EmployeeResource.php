<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Spatie\Permission\Models\Role;
use App\Models\User;
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
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Peran';

    protected static ?string $navigationLabel = 'Karyawan';

    protected static ?string $modelLabel = 'Karyawan';

    protected static ?string $pluralModelLabel = 'Karyawan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Karyawan')
                    ->schema([
                        TextInput::make('position')
                            ->label('Jabatan')
                            ->required(),

                        DatePicker::make('hire_date')
                            ->label('Tanggal Masuk')
                            ->format('Y/m/d')
                            ->required()
                            ->default(now()),

                        Select::make('roles')
                            ->label('Peran')
                            ->options(Role::pluck('name', 'name'))
                            ->preload()
                            ->searchable(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'Aktif',
                                'retired' => 'Pensiun',
                            ])
                            ->required()
                            ->default('active'),
                    ]),

                Section::make('Detail Akun')
                    ->schema([
                        Select::make('user_id')
                            ->label('User')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->searchable()

                            // 1. Provide the initial list of options
                            ->options(function (?Model $record): array {
                                // Get the user ID of the current employee, if we are editing
                                $currentUserId = $record?->user_id;

                                return User::query()
                                    // Get users who don't have an employee record...
                                    ->whereDoesntHave('employee')
                                    // ...OR include the user currently assigned to this record
                                    ->when($currentUserId, fn($query) => $query->orWhere('id', $currentUserId))
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })

                            // 2. Define how to get search results
                            ->getSearchResultsUsing(function (string $search, ?Model $record): array {
                                $currentUserId = $record?->user_id;

                                return User::query()
                                    ->where('name', 'like', "%{$search}%")
                                    // Scope the search to only users who are not employees (or are the current one)
                                    ->where(function ($query) use ($currentUserId) {
                                        $query->whereDoesntHave('employee')
                                            ->when($currentUserId, fn($q) => $q->orWhere('id', '!=', $currentUserId));
                                    })
                                    ->limit(50)
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })

                            // 3. Define how to get the label for a pre-selected user
                            ->getOptionLabelUsing(fn($value): ?string => User::find($value)?->name),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('user.profile_image')
                    ->label('Foto Karyawan')
                    ->width(80)
                    ->height(80),

                TextColumn::make('user.name')
                    ->label('Nama Karyawan'),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope'),

                TextColumn::make('user.phone_number')
                    ->label('Telepon')
                    ->state(function ($record) {
                        return $record->user?->phone_number ?? $record->phone;
                    }),

                TextColumn::make('position')
                    ->label('Jabatan'),

                TextColumn::make('hire_date')
                    ->label('Tanggal Masuk'),

                TextColumn::make('status')
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
