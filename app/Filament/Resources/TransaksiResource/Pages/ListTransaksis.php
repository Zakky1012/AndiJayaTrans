<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource;
use App\Filament\Widgets\TransaksiOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransaksis extends ListRecords
{
    protected static string $resource = TransaksiResource::class;

    public function getHeaderWidgets(): array {
        return [
            TransaksiOverview::class
        ];
    }
    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}
