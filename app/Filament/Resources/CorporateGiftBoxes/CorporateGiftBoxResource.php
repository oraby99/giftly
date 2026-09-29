<?php

namespace App\Filament\Resources\CorporateGiftBoxes;

use App\Filament\Resources\CorporateGiftBoxes\Pages\CreateCorporateGiftBox;
use App\Filament\Resources\CorporateGiftBoxes\Pages\EditCorporateGiftBox;
use App\Filament\Resources\CorporateGiftBoxes\Pages\ListCorporateGiftBoxes;
use App\Filament\Resources\CorporateGiftBoxes\Schemas\CorporateGiftBoxForm;
use App\Filament\Resources\CorporateGiftBoxes\Tables\CorporateGiftBoxesTable;
use App\Models\CorporateGiftBox;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CorporateGiftBoxResource extends Resource
{
    protected static ?string $model = CorporateGiftBox::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $navigationLabel = 'صناديق الشركات';

    protected static ?string $modelLabel = 'صندوق شركات';

    protected static ?string $pluralModelLabel = 'صناديق الشركات';

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): ?string
    {
        return 'المتجر';
    }

    public static function form(Schema $schema): Schema
    {
        return CorporateGiftBoxForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CorporateGiftBoxesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCorporateGiftBoxes::route('/'),
            'create' => CreateCorporateGiftBox::route('/create'),
            'edit' => EditCorporateGiftBox::route('/{record}/edit'),
        ];
    }
}
