<?php

namespace App\Filament\Resources\PackagingOptions\Pages;

use App\Filament\Resources\PackagingOptions\PackagingOptionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPackagingOption extends EditRecord
{
    protected static string $resource = PackagingOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
