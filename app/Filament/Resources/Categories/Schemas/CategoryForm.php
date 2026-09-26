<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('name')
                        ->label('اسم التصنيف')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),

                    TextInput::make('slug')
                        ->label('الرابط المختصر')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                ]),

                Textarea::make('description')
                    ->label('الوصف')
                    ->columnSpanFull()
                    ->rows(3),

                FileUpload::make('image')
                    ->label('الصورة')
                    ->image()
                    ->disk('public')
                    ->directory('categories')
                    ->columnSpanFull(),

                Grid::make(2)->schema([
                    TextInput::make('sort_order')
                        ->label('ترتيب العرض')
                        ->numeric()
                        ->default(0),

                    Toggle::make('is_active')
                        ->label('مفعّل')
                        ->default(true),
                ]),
            ]);
    }
}
