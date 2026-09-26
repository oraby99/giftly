<?php

namespace App\Filament\Resources\GiftBoxes;

use App\Filament\Resources\GiftBoxes\Pages\CreateGiftBox;
use App\Filament\Resources\GiftBoxes\Pages\EditGiftBox;
use App\Filament\Resources\GiftBoxes\Pages\ListGiftBoxes;
use App\Filament\Resources\GiftBoxes\Schemas\GiftBoxForm;
use App\Filament\Resources\GiftBoxes\Tables\GiftBoxesTable;
use App\Models\GiftBox;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GiftBoxResource extends Resource
{
    protected static ?string $model = GiftBox::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGift;

    protected static ?string $navigationLabel = 'صناديق الهدايا';

    protected static ?string $modelLabel = 'صندوق هدايا';

    protected static ?string $pluralModelLabel = 'صناديق الهدايا';

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return 'المتجر';
    }

    public static function form(Schema $schema): Schema
    {
        return GiftBoxForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GiftBoxesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGiftBoxes::route('/'),
            'create' => CreateGiftBox::route('/create'),
            'edit' => EditGiftBox::route('/{record}/edit'),
        ];
    }
}
