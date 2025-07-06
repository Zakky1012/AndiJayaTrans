<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoCodeResource\Pages;
use App\Filament\Resources\PromoCodeResource\RelationManagers;
use App\Models\PromoCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromoCodeResource extends Resource
{
    protected static ?string $model = PromoCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode')
                    ->required(),
                Forms\Components\Select::make('tipe_diskon')
                    ->required()
                    ->options([
                        'fixed' => 'Fixed',
                        'percentage' => 'Percentage'
                    ]),
                Forms\Components\TextInput::make('diskon')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                Forms\Components\DateTimePicker::make('valid')
                    ->required(),
                Forms\Components\Toggle::make('is_used')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode'),
                Tables\Columns\TextColumn::make('tipe_diskon'),
                Tables\Columns\TextColumn::make('diskon')
                    ->formatStateUsing(fn(PromoCode $record): String => match($record->tipe_diskon) {
                        'fixed' => 'Rp ' . number_format($record->diskon, 0, ',', '.'),
                        'percentage' => $record->diskon . '%',
                    }),
                Tables\Columns\TextColumn::make('valid'),
                Tables\Columns\ToggleColumn::make('is_used'),
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
            'index' => Pages\ListPromoCodes::route('/'),
            'create' => Pages\CreatePromoCode::route('/create'),
            'edit' => Pages\EditPromoCode::route('/{record}/edit'),
        ];
    }
}
