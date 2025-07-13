<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\Clock\now;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Halaman';

    protected static ?string $navigationLabel = 'Artikel';

    protected static ?string $modelLabel = 'Artikel';

    protected static ?string $pluralModelLabel = 'Artikel';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->label('Gambar Artikel')
                    ->image()
                    ->directory('articles')
                    ->required()
                    ->visibility('public')
                    ->columnSpan(2),
                TextInput::make('title')
                    ->label('Judul')
                    ->required(),
                RichEditor::make('content')
                    ->label('Isi Artikel')
                    ->required(),
                DatePicker::make('publish_date')
                    ->label('Tanggal Publikasi')
                    ->format('Y/m/d')
                    ->default(now()->format('Y-m-d'))
                    ->hidden()
                    ->required(),
                // Select::make('author_id')
                //     ->label('Author')
                //     ->options(function () {
                //         return \App\Models\Employee::with('users')
                //             ->get()
                //             ->mapWithKeys(function ($employee) {
                //                 return [$employee->id => $employee->users?->name ?? 'Tanpa Nama'];
                //             });
                //     })
                //     ->searchable()
                //     ->required(),
                Hidden::make('author_id')
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
                ImageColumn::make('image')
                    ->label('Gambar Artikel')
                    ->width(150)
                    ->height(150),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Artikel'),
                Tables\Columns\TextColumn::make('publish_date')
                    ->label("Tanggal Publikasi")
                    ->date(),
                Tables\Columns\TextColumn::make('employees.user.name')
                    ->label('Penulis'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
