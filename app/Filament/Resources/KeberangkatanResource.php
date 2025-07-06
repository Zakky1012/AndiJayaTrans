<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KeberangkatanResource\Pages;
use App\Filament\Resources\KeberangkatanResource\RelationManagers;
use App\Models\Keberangkatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KeberangkatanResource extends Resource
{
    protected static ?string $model = Keberangkatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Informasi Keberangkatan')
                        ->schema([
                            Forms\Components\TextInput::make('nomor_keberangkatan')
                                ->required()
                                ->unique(ignoreRecord: true),
                            Forms\Components\Select::make('mobil_id')
                                ->relationship('mobil', 'nama_mobil')
                                ->required()
                        ]),
                    Forms\Components\Wizard\Step::make('Segment Keberangkatan')
                        ->schema([
                            Forms\Components\Repeater::make('segment_keberangkatan')
                                ->relationship('segmentKeberangkatan')
                                ->schema([
                                    Forms\Components\TextInput::make('sequence')
                                        ->numeric()
                                        ->required(),
                                    Forms\Components\Select::make('destinasi_id')
                                        ->relationship('destinasi', 'kota')
                                        ->required(),
                                    Forms\Components\DateTimePicker::make('time')
                                        ->required(),
                                ])
                                ->collapsed(false)
                                ->minItems(1),
                        ]),
                    Forms\Components\Wizard\Step::make('Class Keberangkatan')
                        ->schema([
                            Forms\Components\Repeater::make('class_keberangkatan')
                                ->relationship('classKeberangkatan')
                                ->schema([
                                    Forms\Components\Select::make('tipe_kelas')
                                        ->options([
                                            'ekonomi' => 'Ekonomi',
                                            'premium' => 'Premium',
                                        ])
                                        ->required(),
                                    Forms\Components\TextInput::make('harga')
                                        ->required()
                                        ->prefix('IDR')
                                        ->numeric()
                                        ->minValue(0),
                                    Forms\Components\TextInput::make('total_kursi')
                                        ->required()
                                        ->numeric()
                                        ->minValue(1)
                                        ->label('Total Kursi'),
                                    Forms\Components\Select::make('fasilitas')
                                        ->relationship('fasilitas', 'nama')
                                        ->multiple()
                                        ->required(),
                                ])
                        ]),
                    ])->columnSpan(2)
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListKeberangkatans::route('/'),
            'create' => Pages\CreateKeberangkatan::route('/create'),
            'edit' => Pages\EditKeberangkatan::route('/{record}/edit'),
        ];
    }
}
