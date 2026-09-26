<?php

namespace App\Filament\Resources\CompanyInquiries\Pages;

use App\Filament\Resources\CompanyInquiries\CompanyInquiryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompanyInquiries extends ListRecords
{
    protected static string $resource = CompanyInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
