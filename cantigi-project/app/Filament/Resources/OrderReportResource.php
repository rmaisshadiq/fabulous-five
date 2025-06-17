<?php

namespace App\Filament\Resources;

use App\Models\OrderReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderReportResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;

class OrderReportResource extends Resource
{
    protected static ?string $model = OrderReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Laporan Pemesanan';

    protected static ?string $pluralLabel = 'Orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Empty schema since we don't want create/edit functionality
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer Name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('vehicle.name')
                    ->label('Vehicle Name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('driver.name')
                    ->label('Driver Name')
                    ->searchable()
                    ->sortable(),
                
                // If booking data comes from related tables, adjust these accordingly:
                Tables\Columns\TextColumn::make('customer.booking_start_date') // or wherever this data lives
                    ->label('Start Date')
                    ->date()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('customer.booking_end_date') // or wherever this data lives
                    ->label('End Date')
                    ->date()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('customer.booking_start_time') // or wherever this data lives
                    ->label('Start Time')
                    ->time()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('customer.booking_end_time') // or wherever this data lives
                    ->label('End Time')
                    ->time()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('customer.address') // or wherever drop address is stored
                    ->label('Drop Address')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),
                
                Tables\Columns\BadgeColumn::make('vehicle.status') // or wherever status is stored
                    ->label('Status')
                    ->colors([
                        'danger' => 'cancelled',
                        'warning' => 'pending',
                        'success' => 'completed',
                        'primary' => 'confirmed',
                        'secondary' => 'in_progress',
                    ])
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                
                Tables\Filters\Filter::make('start_booking_date')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('Start Date From'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Start Date Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('start_booking_date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('start_booking_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Remove EditAction and DeleteAction to prevent modifications
            ])
            ->bulkActions([
                // Remove bulk actions to prevent bulk operations
            ])
            ->defaultSort('start_booking_date', 'desc');
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
            'index' => Pages\ListOrderReports::route('/'),
            // 'view' => Pages\OrderReport::route('/{record}'),
            // Remove create and edit pages
        ];
    }

    // Disable create action globally
    public static function canCreate(): bool
    {
        return false;
    }

    // Disable edit action globally
    public static function canEdit($record): bool
    {
        return false;
    }

    // Disable delete action globally (optional)
    public static function canDelete($record): bool
    {
        return false;
    }
}