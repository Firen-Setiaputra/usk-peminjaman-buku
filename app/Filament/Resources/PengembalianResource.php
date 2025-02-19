<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengembalianResource\Pages;
use App\Filament\Resources\PengembalianResource\RelationManagers;
use App\Models\Pengembalian;
use App\Models\Borrowing;
use App\Models\user;
use App\Models\Buku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengembalianResource extends Resource
{
    protected static ?string $model = Pengembalian::class;

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Pengembalian')->schema([
                Forms\Components\Select::make('borrowing_id')
                ->label('Peminjaman')
                ->relationship('borrowing', 'id', function ($query){
                    return $query->where('status', 'dipinjam');
                })
                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->user->name} - {$record->buku->judul} (ISBN: {$record->buku->isbn})")
                // ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('tanggal_pengembalian')
                ->label('Tanggal Pengembalian')
                ->default(now())
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get){
                    $peminjaman = \App\Models\Borrowing::find($get('borrowing_id'));
                    if ($peminjaman){
                        $denda = \App\Models\Borrowing::hitungdenda($state, $peminjaman->jatuh_tempo);
                        $set('denda', $denda);
                    }
                })
                ->default(now()->format('Y-m-d')) // Formatkan sesuai kebutuhan
                    ->maxLength(255),
                Forms\Components\TextInput::make('denda')
                    ->label('Denda (Rp)')
                    ->readOnly()
                    ->numeric()
                    ->default(0),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('borrowing.user.name')
                ->label('Peminjam & Buku')
                ->formatStateUsing(fn ($record) => "{$record->borrowing->user->name} - {$record->borrowing->buku->judul}")
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_pengembalian')
                ->label('Tanggal Pengembalian')
                ->date()
                // ->numeric()
                ->searchable(),
                Tables\Columns\TextColumn::make('denda')
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
            'index' => Pages\ListPengembalians::route('/'),
            'create' => Pages\CreatePengembalian::route('/create'),
            'edit' => Pages\EditPengembalian::route('/{record}/edit'),
        ];
    }
}
