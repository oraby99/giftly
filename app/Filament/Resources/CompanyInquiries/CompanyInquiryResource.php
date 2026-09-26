<?php

namespace App\Filament\Resources\CompanyInquiries;

use App\Filament\Resources\CompanyInquiries\Pages\CreateCompanyInquiry;
use App\Filament\Resources\CompanyInquiries\Pages\EditCompanyInquiry;
use App\Filament\Resources\CompanyInquiries\Pages\ListCompanyInquiries;
use App\Filament\Resources\CompanyInquiries\Schemas\CompanyInquiryForm;
use App\Filament\Resources\CompanyInquiries\Tables\CompanyInquiriesTable;
use App\Models\CompanyInquiry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CompanyInquiryResource extends Resource
{
    protected static ?string $model = CompanyInquiry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static ?string $navigationLabel = 'طلبات الشركات';

    protected static ?string $modelLabel = 'طلب شركة';

    protected static ?string $pluralModelLabel = 'طلبات الشركات';

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return 'المبيعات';
    }

    public static function form(Schema $schema): Schema
    {
        return CompanyInquiryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompanyInquiriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompanyInquiries::route('/'),
            'create' => CreateCompanyInquiry::route('/create'),
            'edit' => EditCompanyInquiry::route('/{record}/edit'),
        ];
    }
}
