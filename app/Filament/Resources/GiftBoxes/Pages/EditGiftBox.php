<?php

namespace App\Filament\Resources\GiftBoxes\Pages;

use App\Filament\Resources\GiftBoxes\GiftBoxResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditGiftBox extends EditRecord
{
    protected static string $resource = GiftBoxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
