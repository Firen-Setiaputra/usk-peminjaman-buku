<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BukuResource\Pages;
use App\Filament\Resources\BukuResource\RelationManagers;
use App\Models\Buku;
use Filament\Actions\StaticAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BukuResource extends Resource
{
    protected static ?string $model = Buku::class;

    protected static ?string $pluralLabel = 'Daftar Buku';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\TextInput::make('penulis')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\TextInput::make('penerbit')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\TextInput::make('tahun')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('isbn')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('kategori_id')
                    ->relationship('kategori', 'nama_kategori')
                    ->required(),
                Forms\Components\TextInput::make('jumlah')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->limit('50'),
                Tables\Columns\TextColumn::make('penulis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penerbit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('isbn')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kategori.nama_kategori')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])

                    ->query(Buku::query()->withTrashed()) // Menampilkan semua data, termasuk yang dihapus
                    ->actions([
                        Tables\Actions\DeleteAction::make(), // Menghapus data dengan soft delete
                        Tables\Actions\RestoreAction::make(), // Mengembalikan data yang dihapus
                        Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBukus::route('/'),
            'create' => Pages\CreateBuku::route('/create'),
            'edit' => Pages\EditBuku::route('/{record}/edit'),
        ];
    }

    // public static function CanViewAny (): bool
    // {
    //     return auth()->user()->jenis === 'admin';
    // }

    public Static function canCreate (): bool
    {
        return auth()->user()->jenis === 'admin';
    }

    public static function canEdit ($record): bool
    {
        return auth()->user()->jenis === 'admin';
    }
    public static function canDelete ($record): bool
    {
        return auth()->user()->jenis === 'admin';
    }
}
