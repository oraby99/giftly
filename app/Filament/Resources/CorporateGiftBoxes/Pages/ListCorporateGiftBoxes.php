<?php

namespace App\Filament\Resources\CorporateGiftBoxes\Pages;

use App\Filament\Resources\CorporateGiftBoxes\CorporateGiftBoxResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCorporateGiftBoxes extends ListRecords
{
    protected static string $resource = CorporateGiftBoxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('إضافة صندوق شركات جديد'),
        ];
    }
}
