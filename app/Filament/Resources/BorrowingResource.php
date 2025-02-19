<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BorrowingResource\Pages;
use App\Filament\Resources\BorrowingResource\RelationManagers;
use App\Models\Borrowing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Peminjaman;
use App\Models\Buku;

class BorrowingResource extends Resource
{
    protected static ?string $model = Borrowing::class;

    protected static ?string $label = 'Pinjaman';
    protected static ?string $pluralLabel = 'Peminjaman';
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canDelete ($record): bool
    {
        return auth()->user()->jenis === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('buku_id')
                ->relationship('buku', 'judul')
                ->required()
                ->options(Buku::all()->pluck('judul', 'id')),
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->required(),
                Forms\Components\DatePicker::make('tgl_pinjam')
                ->required()
                ->default(now()->format('Y-m-d')), // Formatkan sesuai kebutuhan,
                Forms\Components\DatePicker::make('tgl_kembali')
                ->required()
                ->default(now()->addDays(7)), // Tanggal pengembalian otomatis,
                Forms\Components\Select::make('status')
                    ->options(['dipinjam' => 'Dipinjam'])
                    ->required(), 
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
                ->columns([
                    Tables\Columns\TextColumn::make('buku.judul')
                    ->label('Buku')
                        ->sortable()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('user.name')
                        ->label('Peminjam')
                        ->sortable()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('tgl_pinjam')
                        ->searchable()
                        ->label('Tanggal Pinjam'),
                    Tables\Columns\TextColumn::make('tgl_kembali')
                        ->searchable()
                        ->label('Tanggal Kembali'),
                    Tables\Columns\TextColumn::make('status')
                    ->label('Status'),
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
            ->actions([
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
            'index' => Pages\ListBorrowings::route('/'),
            'create' => Pages\CreateBorrowing::route('/create'),
            'edit' => Pages\EditBorrowing::route('/{record}/edit'),
        ];
    }
}
