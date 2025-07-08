<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KeberangkatanResource\Pages;
use App\Filament\Resources\KeberangkatanResource\RelationManagers;
use App\Models\Keberangkatan;
use DateTime;
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
                Tables\Columns\TextColumn::make('nomor_keberangkatan'),
                Tables\Columns\TextColumn::make('mobil.nama_mobil'),
                Tables\Columns\TextColumn::make('segmentKeberangkatan')
                    ->label('Route & Duration')
                    ->formatStateUsing(function (Keberangkatan $record): string {
                        $firstSegment  = $record->segmentKeberangkatan->first();
                        $lastSegment   = $record->segmentKeberangkatan->last();
                        $route         = $firstSegment->destinasi->iata_code.' - '.$lastSegment->destinasi->iata_code;
                        $duration      = (new DateTime($firstSegment->time))->format('d F Y H:i').' - '.(new DateTime($lastSegment->time))->format('d F Y H:i');
                        return $route . ' | ' . $duration;
                    }),
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
            'index' => Pages\ListKeberangkatans::route('/'),
            'create' => Pages\CreateKeberangkatan::route('/create'),
            'edit' => Pages\EditKeberangkatan::route('/{record}/edit'),
        ];
    }
}
