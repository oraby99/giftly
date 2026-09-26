<?php

namespace App\Filament\Resources\PackagingOptions\Pages;

use App\Filament\Resources\PackagingOptions\PackagingOptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPackagingOptions extends ListRecords
{
    protected static string $resource = PackagingOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
