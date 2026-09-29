<?php

namespace App\Filament\Resources\CorporateGiftBoxes\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CorporateGiftBoxForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('معلومات صندوق الشركات')
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
                                ->label('السعر التقديري (يبدأ من)')
                                ->numeric()
                                ->suffix('ج.م')
                                ->minValue(0)
                                ->helperText('اتركه فارغاً إذا كان السعر يحدد حسب الكمية والمواصفات'),

                            TextInput::make('min_quantity')
                                ->label('الحد الأدنى للطلب')
                                ->numeric()
                                ->default(10)
                                ->minValue(1)
                                ->suffix('صندوق'),
                        ]),

                        Textarea::make('description')
                            ->label('وصف الصندوق والمناسبات المناسبة له')
                            ->rows(3)
                            ->placeholder('مثال: باقة فاخرة مخصصة لتقدير الموظفين الجدد وشركاء النجاح مع طباعة هوية الشركة...'),

                        Repeater::make('features')
                            ->label('ميزات ومحتويات الصندوق')
                            ->simple(
                                TextInput::make('item')
                                    ->placeholder('مثال: مج حراري مطبوع بشعار الشركة')
                                    ->required()
                            )
                            ->addActionLabel('+ إضافة عنصر / ميزة')
                            ->collapsible(),
                    ]),

                Section::make('الصورة والحالة')
                    ->columnSpan(1)
                    ->schema([
                        FileUpload::make('image')
                            ->label('صورة الصندوق')
                            ->image()
                            ->directory('corporate-boxes')
                            ->disk('public'),

                        Toggle::make('is_active')
                            ->label('متاح في صفحة الشركات')
                            ->default(true),

                        TextInput::make('sort_order')
                            ->label('ترتيب العرض')
                            ->numeric()
                            ->default(0),
                    ]),
            ]);
    }
}
