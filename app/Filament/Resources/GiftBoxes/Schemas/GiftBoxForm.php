<?php

namespace App\Filament\Resources\GiftBoxes\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class GiftBoxForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('معلومات صندوق الهدايا')
                    ->columnSpan(2)
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('اسم الصندوق')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),

                            TextInput::make('slug')
                                ->label('الرابط المختصر')
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true),

                            TextInput::make('price')
                                ->label('سعر البيع')
                                ->required()
                                ->numeric()
                                ->suffix('ج.م')
                                ->minValue(0)
                                ->helperText('السعر الثابت للصندوق بغض النظر عن محتوياته'),

                            TextInput::make('sort_order')
                                ->label('ترتيب العرض')
                                ->numeric()
                                ->default(0),
                        ]),

                        Textarea::make('description')
                            ->label('الوصف')
                            ->rows(4),

                        Select::make('occasions')
                            ->label('المناسبات')
                            ->relationship('occasions', 'name')
                            ->multiple()
                            ->preload(),
                    ]),

                Section::make('الصورة والخيارات')
                    ->columnSpan(1)
                    ->schema([
                        FileUpload::make('image')
                            ->label('الصورة الرئيسية')
                            ->image()
                            ->disk('public')
                            ->directory('gift-boxes'),

                        Toggle::make('is_active')
                            ->label('متاح للبيع')
                            ->default(true),

                        Toggle::make('is_featured')
                            ->label('صندوق مميز')
                            ->default(false),
                    ]),

                Section::make('محتويات الصندوق')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('items')
                            ->label('')
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->label('المنتج')
                                    ->relationship('product', 'name')
                                    ->searchable()
                                    ->required(),

                                TextInput::make('quantity')
                                    ->label('الكمية')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->required(),
                            ])
                            ->columns(2)
                            ->addActionLabel('إضافة منتج'),
                    ]),
            ]);
    }
}
