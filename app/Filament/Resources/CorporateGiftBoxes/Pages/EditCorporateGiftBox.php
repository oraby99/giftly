<?php

namespace App\Filament\Resources\CorporateGiftBoxes\Pages;

use App\Filament\Resources\CorporateGiftBoxes\CorporateGiftBoxResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCorporateGiftBox extends EditRecord
{
    protected static string $resource = CorporateGiftBoxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->label('حذف'),
        ];
    }
}
