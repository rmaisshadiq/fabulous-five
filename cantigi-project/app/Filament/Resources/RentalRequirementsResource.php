<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RentalRequirementsResource\Pages;
use App\Filament\Resources\RentalRequirementsResource\RelationManagers;
use App\Models\RentalRequirements;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RentalRequirementsResource extends Resource
{
    protected static ?string $model = RentalRequirements::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Rental';

    protected static ?string $navigationLabel = 'Persyaratan';

    protected static ?string $modelLabel = 'Persyaratan';

    protected static ?string $pluralModelLabel = 'Persyaratan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('resident_id_card')
                    ->image()
                    ->directory('verification/resident_ids')
                    ->required()
                    ->columnSpan(2),

                FileUpload::make('work_or_student_id_card')
                    ->image()
                    ->directory('verification/work_student_ids')
                    ->required()
                    ->columnSpan(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.user.name')
                    ->label('Nama Customer')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('resident_id_card')
                    ->label('KTP')
                    ->height(54)
                    ->width(86),
                ImageColumn::make('work_or_student_id_card')
                    ->label('KTM atau NPWP')
                    ->height(54)
                    ->width(86),
                TextColumn::make('deposit_amount')
                    ->label('Deposit awal'),
                TextColumn::make('social_media_link')
                    ->label('Akun Sosmed'),
                TextColumn::make('verifiedBy.user.name')
                    ->label('Diverifikasi oleh')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('verify')
                    ->label('Verify')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn($record) => $record->customer->verification_status !== 'verified')
                    ->requiresConfirmation()
                    ->modalHeading('Verify Customer')
                    ->modalDescription('Are you sure you want to verify this customer?')
                    ->modalSubmitActionLabel('Yes, Verify')
                    ->action(function ($record) {
                        // Update customer verification status
                        $record->customer->update([
                            'verification_status' => 'verified'
                        ]);

                        // Update rental requirement with verified_by
                        $record->update([
                            'verified_by' => Auth::user()->employee->id
                        ]);

                        // Show success notification
                        Notification::make()
                            ->title('Customer Verified Successfully')
                            ->body('The customer has been verified and your ID has been recorded.')
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
            'index' => Pages\ListRentalRequirements::route('/'),
            'create' => Pages\CreateRentalRequirements::route('/create'),
            'edit' => Pages\EditRentalRequirements::route('/{record}/edit'),
        ];
    }
}
