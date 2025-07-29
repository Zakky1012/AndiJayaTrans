<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Models\Transaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi umum')
                    ->schema([
                        Forms\Components\TextInput::make('kode'),
                        Forms\Components\Select::make('keberangkatan_id')
                            ->relationship('keberangkatan', 'nomor_keberangkatan'),
                        Forms\Components\Select::make('keberangkatan_class_id')
                            ->relationship('classKeberangkatan', 'tipe_kelas'),
                    ]),
                Forms\Components\Section::make('Informasi penumpang')
                    ->schema([
                       Forms\Components\TextInput::make('nomor_pessenger'),
                       Forms\Components\TextInput::make('nama'),
                       Forms\Components\TextInput::make('email'),
                       Forms\Components\TextInput::make('nomor'),
                       Forms\Components\Section::make('Daftar Penumpang')
                            ->schema([
                                Forms\Components\Repeater::make('Passenger')
                                ->relationship('transaksiPessenger')
                                ->schema([
                                    Forms\Components\Select::make('kursi_keberangkatan_id')
                                        ->label('Seat Name')
                                        ->relationship('kursi', 'name')
                                        ->required(),
                                    Forms\Components\TextInput::make('nama'),
                                    Forms\Components\TextInput::make('date_of_birth'),
                                    Forms\Components\TextInput::make('kewarganeraan'),
                                ])
                            ])
                    ]),
                Forms\Components\Section::make('Pembayaran')
                    ->schema([
                        Forms\Components\Select::make('kode_promo_id')
                            ->relationship('promoCode','kode'),
                        Forms\Components\TextInput::make('status_payment'),
                        Forms\Components\TextInput::make('sub_total'),
                        Forms\Components\TextInput::make('grand_total'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode'),
                Tables\Columns\TextColumn::make('keberangkatan.nomor_keberangkatan'),
                Tables\Columns\TextColumn::make('nomor_pessenger'),
                Tables\Columns\TextColumn::make('nama'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('nomor'),
                Tables\Columns\TextColumn::make('nomor_pessenger'),
                Tables\Columns\TextColumn::make('promo_code.kode'),
                Tables\Columns\TextColumn::make('status_payment'),
                Tables\Columns\TextColumn::make('sub_total'),
                Tables\Columns\TextColumn::make('grand_total'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
