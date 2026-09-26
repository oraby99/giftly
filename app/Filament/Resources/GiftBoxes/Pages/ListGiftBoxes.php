<?php

namespace App\Filament\Resources\GiftBoxes\Pages;

use App\Filament\Resources\GiftBoxes\GiftBoxResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGiftBoxes extends ListRecords
{
    protected static string $resource = GiftBoxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
