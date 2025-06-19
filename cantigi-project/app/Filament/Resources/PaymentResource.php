<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('payment_date') // Perbaikan typo dari 'paryment_date'
                ->date()
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('amount')
                ->money('IDR') // Format sebagai mata uang
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('payment_method')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'qris' => 'success',
                    'bca' => 'primary',
                    'mandiri' => 'blue',
                    'bni' => 'warning',
                    'bri' => 'danger',
                    default => 'gray',
                })
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'paid' => 'success',
                    'pending' => 'warning',
                    'failed' => 'danger',
                    default => 'gray',
                })
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('transaction_id')
                ->searchable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('payment_method')
                ->options([
                    'qris' => 'QRIS',
                    'bca' => 'BCA',
                    'mandiri' => 'Mandiri',
                    'bni' => 'BNI',
                    'bri' => 'BRI',
                ]),
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'paid' => 'Paid',
                    'pending' => 'Pending',
                    'failed' => 'Failed',
                ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPayments::route('/'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
