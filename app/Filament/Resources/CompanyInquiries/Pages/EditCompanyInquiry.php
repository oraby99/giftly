<?php

namespace App\Filament\Resources\CompanyInquiries\Pages;

use App\Filament\Resources\CompanyInquiries\CompanyInquiryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCompanyInquiry extends EditRecord
{
    protected static string $resource = CompanyInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
