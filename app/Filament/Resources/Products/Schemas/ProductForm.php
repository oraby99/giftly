<?php

namespace App\Filament\Resources\Products\Schemas;

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

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('معلومات المنتج')
                    ->columnSpan(2)
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('اسم المنتج')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),

                            TextInput::make('slug')
                                ->label('الرابط المختصر')
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true),

                            Select::make('category_id')
                                ->label('التصنيف')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload(),

                            TextInput::make('price')
                                ->label('السعر')
                                ->required()
                                ->numeric()
                                ->suffix('ج.م')
                                ->minValue(0),

                            TextInput::make('stock_quantity')
                                ->label('الكمية المتاحة')
                                ->numeric()
                                ->minValue(0)
                                ->helperText('اتركه فارغاً لعدم تتبع المخزون'),
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

                Section::make('الصور والخيارات')
                    ->columnSpan(1)
                    ->schema([
                        FileUpload::make('image')
                            ->label('الصورة الرئيسية')
                            ->image()
                            ->disk('public')
                            ->directory('products'),

                        Toggle::make('is_active')
                            ->label('متاح للبيع')
                            ->default(true),

                        Toggle::make('is_featured')
                            ->label('منتج مميز')
                            ->default(false),
                    ]),

                Section::make('صور إضافية')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('images')
                            ->label('')
                            ->relationship()
                            ->schema([
                                FileUpload::make('image')
                                    ->label('الصورة')
                                    ->image()
                                    ->disk('public')
                                    ->directory('products')
                                    ->required(),

                                TextInput::make('sort_order')
                                    ->label('الترتيب')
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->columns(2)
                            ->addActionLabel('إضافة صورة'),
                    ]),
            ]);
    }
}
