<?php

namespace App\Filament\Resources\PackagingOptions\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class PackagingOptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('name')
                        ->label('اسم التغليف')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('price')
                        ->label('السعر')
                        ->required()
                        ->numeric()
                        ->suffix('ج.م')
                        ->minValue(0)
                        ->default(0),

                    TextInput::make('sort_order')
                        ->label('الترتيب')
                        ->numeric()
                        ->default(0),

                    Toggle::make('is_active')
                        ->label('مفعّل')
                        ->default(true),
                ]),

                Textarea::make('description')
                    ->label('الوصف')
                    ->rows(2)
                    ->columnSpanFull(),
            ]);
    }
}
