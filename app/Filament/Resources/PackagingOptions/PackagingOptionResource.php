<?php

namespace App\Filament\Resources\PackagingOptions;

use App\Filament\Resources\PackagingOptions\Pages\CreatePackagingOption;
use App\Filament\Resources\PackagingOptions\Pages\EditPackagingOption;
use App\Filament\Resources\PackagingOptions\Pages\ListPackagingOptions;
use App\Filament\Resources\PackagingOptions\Schemas\PackagingOptionForm;
use App\Filament\Resources\PackagingOptions\Tables\PackagingOptionsTable;
use App\Models\PackagingOption;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PackagingOptionResource extends Resource
{
    protected static ?string $model = PackagingOption::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBox;

    protected static ?string $navigationLabel = 'خيارات التغليف';

    protected static ?string $modelLabel = 'خيار تغليف';

    protected static ?string $pluralModelLabel = 'خيارات التغليف';

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): ?string
    {
        return 'المتجر';
    }

    public static function form(Schema $schema): Schema
    {
        return PackagingOptionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PackagingOptionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPackagingOptions::route('/'),
            'create' => CreatePackagingOption::route('/create'),
            'edit' => EditPackagingOption::route('/{record}/edit'),
        ];
    }
}
